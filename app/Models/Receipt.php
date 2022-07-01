<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use Session;

use App\Models\Setting;
use App\Helpers\MathHelper;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'receipt';
    protected $primaryKey = 'receipt_id';


    protected $attributes = [

      
        "receipt_discount" => '{
            "1": {
                "type": "",
                "value": ""
            }
        }'

       
    ];

    protected $casts = [
      
        "receipt_discount" => 'array'
    ];

    public static function List($column,  $filter){
        return Receipt::
        leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
        ->leftJoin('store', 'store.store_id', '=', 'stock.stock_account_id')
        ->where($column,  $filter)
        ->orderBy('stock.created_at', 'desc');
    }

    public static function Order(){
        return Receipt::
        leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
        ->leftJoin('order', 'order.order_id', '=', 'receipt.receipt_order_id');
    }

    public static function Bag($column,  $filter){
        return Receipt::
        leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
        ->leftJoin('user', 'user.user_id', 'receipt.receipt_user_id')
        ->where($column,  $filter);
    }


    public static function Quantity($cartList){
        $count = 0;

        foreach ($cartList as $cartItem) {
            $count = $count + intval($cartItem['stock_quantity']);
        }

        return $count;
    }

    public static function ReceiptCostOverrideType(){
        return [
            '%',
            '£'
        ];
    }

    public static function SessionDisplay($sessionCartList){
        
        $stockList = NULL;

        foreach ($sessionCartList as $sessionCartList) {

            $stock = Stock::find($sessionCartList['stock_id']);

            $cost = Stock::StockCostDefault($stock->stock_cost);
            $stock_vat = Stock::StockVAT($stock);
            
            $stockList[] = [
                'stock_id' => $stock->stock_id,
                'stock_name' => $stock->stock_merchandise['stock_name'],
                'stock_quantity' => $sessionCartList['stock_quantity'],
                'stock_cost' => MathHelper::FloatRoundUp($cost, 2),
                'stock_vat_id' => $stock->stock_merchandise['stock_vat_id'],
                'stock_discount' => $sessionCartList['stock_discount'], //manually added
                'stock_offer_id' =>  $stock->stock_merchandise['stock_offer_id']
            ];
        } 

        return $stockList;
    }

    public static function ReceiptDisplay($sessionCartList){
        
        $receipt_setting_vat = NULL;

        foreach ($sessionCartList as $stock) {
            
           if ($stock->receipt_setting_vat) {
                $receipt_setting_vat = array_sum($stock->receipt_setting_vat);
           }

            $stockList[] = [
                'stock_id' => $stock->stock_id,
                'stock_name' => json_decode($stock->stock_merchandise, true)['stock_name'],
                'stock_quantity' => $stock->receipt_stock_quantity,
                'stock_cost' => MathHelper::FloatRoundUp($stock->receipt_stock_cost, 2),
                'stock_vat_id' =>  $receipt_setting_vat,
                'stock_discount' =>  $receipt_discount, //manually added
                'stock_offer_id' =>  $stock->stock_merchandise['stock_offer_id']
            ];
        } 

        return $stockList;
    }

    //data , stock , loop
    public static function Calculate($data, $stockItem, $loop, $receipt){
        //convert sting to val
        $receipt['price'] = $stockItem['stock_cost'] * intval($stockItem['stock_quantity']);
        $receipt['stock_vat_rate'] = null;


        if ($stockItem['stock_offer_id']) {
          
            $stock = Stock::find($stockItem['stock_id']);
            $stockCurrentOffer = Stock::StockCurrentOffer($stock, array_search('discount', Setting::DiscountType()) );
            
            //if there is an offer on stock
            if ($stockCurrentOffer) {
                $receipt['stockCurrentOfferType'] = Stock::StockCurrentOfferType( $receipt['totalPrice'], $stockCurrentOffer, $receipt['price']);
                $receipt['price'] = Stock::StockCostMin( $receipt['stockCurrentOfferType'] );
            }
            
        }

        if ($stockItem['stock_vat_id']) {
            $receipt['stock_vat_rate'] = $data['settingModel']->setting_vat[$stockItem['stock_vat_id']]['rate'];
            $receipt['totalPrice'] = $receipt['totalPrice'] + MathHelper::VAT($receipt['stock_vat_rate'], $receipt['price']);
        } else {
            $receipt['totalPrice'] = $receipt['price'] + $receipt['totalPrice'];
        }

        if ($loop->last) {
            
            //final discount
            if (Session::has('user-session-'.Auth::user()->user_id. '.discountList')) {
                if (count(Session::get('user-session-'.Auth::user()->user_id. '.discountList')) > 0) {

                    foreach (Session::get('user-session-'.Auth::user()->user_id. '.discountList') as $key => $value) {
                       
                        //check if value has percentage

                        if ( Str::contains($value['value'], '%') ) {
                            $discountValue = Str::remove('%', $value['value']);
                            $receipt['totalPrice'] =  $receipt['totalPrice'] - MathHelper::Discount($discountValue, $receipt['totalPrice']);
                        } else {
                            $discountValue = MathHelper::PercentageDifference($value['value'], $receipt['totalPrice']);
                            $receipt['totalPrice'] = $receipt['totalPrice'] - $value['value'];
                        }

                        
                        $receipt['discountTotal'] = $receipt['discountTotal'] + $discountValue;
                       
                    }
                }
            }

            //add delivery cost
            if (Session::has('user-session-'.Auth::user()->user_id. '.deliveryList')) {
                if (count(Session::get('user-session-'.Auth::user()->user_id. '.deliveryList')) > 0) {
                    $receipt['deliveryTotal'] = collect(Session::get('user-session-'.Auth::user()->user_id. '.deliveryList'))->sum('value');
                    $receipt['priceVAT'] = $receipt['priceVAT'] + $receipt['deliveryTotal'];
                }
            }

            $receipt['totalSettingVAT'] = collect($data['settingModel']->setting_vat)->where('deafult', 0)->sum('rate');
            $receipt['priceVAT'] = $receipt['priceVAT'] + MathHelper::VAT($receipt['totalSettingVAT'], $receipt['totalPrice']);

           
        }

        return $receipt;

    }


   
}
