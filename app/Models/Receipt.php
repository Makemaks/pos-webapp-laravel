<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

use App\Models\Setting;
use App\Helpers\MathHelper;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'receipt';
    protected $primaryKey = 'receipt_id';


    public $timestamps = true;

    protected $attributes = [
        "receipt_setting_key" => '{}'
    ];

    protected $casts = [
      
        "receipt_setting_key" => 'array'
    ];

    public static function List($column,  $filter){
        return Receipt::
        leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
        ->leftJoin('store', 'store.store_id', '=', 'stock.stock_account_id')
        ->where($column,  $filter)
        ->orderBy('stock.created_at', 'desc');
    }

    public static function Order($column,  $filter){
        return Receipt::
        leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
        ->leftJoin('order', 'order.order_id', '=', 'receipt.receipt_order_id')
        ->leftJoin('store', 'store.store_id', '=', 'order.order_store_id')
        ->leftJoin('user', 'user.user_id', '=', 'order.ordertable_id')
        ->where($column,  $filter);
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

    public static function ReceiptPriceOverrideType(){
        return [
            '%',
            '£'
        ];
    }

   
    public static function SessionInitialize($request){

        $request = Receipt::Empty($request);

        if ( $request->session()->has('user-session-'.Auth::user()->user_id.'.'.'setupList') == false) {
            $setupList = [
                "cash" => [],
                "credit" => [],
                "voucher" => [],
                "delivery" => [],
                "discount" => [],
                "customer" => [],
                "order_setting_key" => [],
                //"receipt_setting_key" => [],
                "order_offer" => [],
                "receipt" => [
                    "deliveryTotal" => 0,
                    "voucherAmountTotal" => 0,
                    "voucherPercentageTotal" => 0,
                    "discountAmountTotal" => 0,
                    "discountPercentageTotal" => 0,
                    "creditTotal" => 0,
                    "cashTotal" => 0,
                    "priceVATTotal" => 0,
                    "priceTotal" => 0,
                    "subTotal" => 0,
                    "priceFinalTotal" => 0,
                    'stock' => ['stock_price' => 0, 'stock_price_processed' => 0],
                    'finalise_key' => ['value' => 0, 'type' => 0]
                ],
                

            ];
            

            $request->session()->put('user-session-'.Auth::user()->user_id.'.'.'setupList', $setupList);
           
        }

        $setupList =  $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList');

        return $setupList;
    }

    public static function SessionCartInitialize($sessionCartList){
        
        $stockList = NULL;

        foreach ($sessionCartList as $sessionCart) {

            $stock = Stock::find($sessionCart['stock_id']);

            $price = Stock::StockPriceDefault($stock->stock_price);
            $stock_vat = Stock::StockVAT($stock);
            
            $stockList[] = [
                'stock_id' => $stock->stock_id,
                'user_id' => $sessionCart['user_id'],
                'store_id' => $sessionCart['store_id'],
                'stock_name' => $stock->stock_merchandise['stock_name'],
                'stock_quantity' => $sessionCart['stock_quantity'],
                'stock_price' => MathHelper::FloatRoundUp($price, 2),
                'stock_vat_id' => $stock->stock_merchandise['stock_vat_id'],
                'stock_discount' => $sessionCart['stock_discount'], //manually added
                'setting_offer_id' =>  $stock->stock_merchandise['setting_offer_id']
            ];
        } 

        return $stockList;
    }

    public static function ReceiptDisplay($orderList){
        //reinitialise session values for cart
        $receipt_setting_vat = NULL;

        foreach ($orderList as $receipt) {
            
           if ($receipt->receipt_setting_vat) {
                $receipt_setting_vat = array_sum($receipt->receipt_setting_vat);
           }

            $stock = Stock::find($receipt['stock_id']);

            $price = Stock::StockPriceDefault($stock->stock_price);
            //$stock_vat = Stock::StockVAT($stock);

            $stockList[] = [
                'stock_id' => $stock->stock_id,
                'user_id' => $receipt['user_id'],
                'stock_name' => $stock->stock_merchandise['stock_name'],
                'stock_quantity' => $receipt['receipt_quantity'],
                'stock_price' => MathHelper::FloatRoundUp($price, 2),
                'stock_vat_id' => $stock->stock_merchandise['stock_vat_id'],
                'stock_discount' => json_decode($receipt['receipt_discount'], true), //manually added
                'setting_offer_id' =>  $stock->stock_merchandise['setting_offer_id']
            ];
        } 

        return $stockList;
    }

    //data , stock , loop
    public static function Calculate($data, $stockItem, $loop){
        //convert sting to val
        
        $stock = Stock::find($stockItem['stock_id']);
        $data['setupList']['receipt']['stock_vat_rate'] = 0;
        $stockItem['stock_vat_id'] = $stock->stock_merchandise['stock_vat_id'];
      
        //stock current offer or price
        $data['setupList'] = Stock::StockPriceProcessed($stock, $data['setupList']);
        //get quantity
        $stock_price_processed = Stock::StockPriceQuantity( $data['setupList']['receipt']['stock']['stock_price_processed'], $stockItem['stock_quantity']);

        //stock vat
        if ($stockItem['stock_vat_id']) {
            $data['setupList']['receipt']['stock_vat_rate'] = $data['settingModel']->setting_vat[$stockItem['stock_vat_id']]['rate'];
            $stock_price_processed = MathHelper::VAT($data['setupList']['receipt']['stock_vat_rate'], $stock_price_processed);
        }

        $data['setupList']['receipt']['stock']['stock_price_processed'] = $stock_price_processed;

        //add price to subtotal
        if($loop->first){
            $data['setupList']['receipt']['subTotal'] = 0;
        }

        $data['setupList']['receipt']['subTotal'] = $data['setupList']['receipt']['subTotal'] + $stock_price_processed;


        if ($loop->last) {
            
            //final discount
             //calculate overall vat
            $data = Setting::SettingFinaliseKey($data);
            $data['setupList']['receipt']['totalSettingVAT'] = collect($data['settingModel']->setting_vat)->where('default', 0)->sum('rate');
            
            $data['setupList']['receipt']['priceVATTotal'] = MathHelper::VAT($data['setupList']['receipt']['totalSettingVAT'], $data['setupList']['receipt']['subTotal']);
            $data['setupList']['receipt']['priceVATTotal'] =  $data['setupList']['receipt']['priceVATTotal'] + $data['setupList']['receipt']['priceTotal'];
            
        }

        return $data;

    }


    
     /* 
        Session Manager 
        Used to manipulate session data
    */
    public static function Recover(Request $request, $receipt){

        if ($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList')) {
            
            $this->sessionCartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList.'.$receipt); 
            $request->session()->put('user-session-'.Auth::user()->user_id. '.cartList', $this->sessionCartList);       
        }

        //return redirect()->route('home.index');
       
    }


    public static function Suspend(Request $request){

        if($request->session()->has('user-session-'.Auth::user()->user_id)){
            //remove session
            $cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList');
            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList', $cartList);
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
        }

        //return back()->with('success', 'Receipt on Suspend');
    
    }

    public static function Awaiting(Request $request){

        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList')){
            //remove session
            $this->sessionCartList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList');
        }

        //return view('receipt-manager.awaiting.index', ['data' => $this->Data()]);
    
    }

    public static function Empty(Request $request){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'cartList');
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
        }

        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'setupList')){
            $request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'setupList');
        }
    
        return $request;
    }

    //remove item
    public static function Remove(Request $request, $receipt){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList.'.$receipt);
            
        }

        return $request;
    
    }


    public static function Complete(Request $request, $product){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList', $product);
        }

        return $request;
    
    }

    public static function ReceiptStatus(){
        return [
            'processed',
            'cancelled',
            'refunded'
        ];
           
      
    }
   
}
