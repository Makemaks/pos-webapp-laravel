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

    public static function Order($column,  $filter){
        return Receipt::
        leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
        ->leftJoin('order', 'order.order_id', '=', 'receipt.receipt_order_id')
        ->leftJoin('store', 'store.store_id', '=', 'stock.stock_store_id')
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

    public static function ReceiptCostOverrideType(){
        return [
            '%',
            '£'
        ];
    }


    public static function SessionInitialize($request){
        if ( $request->session()->has('user-session-'.Auth::user()->user_id.'.'.'setupList') == false) {
            $setupList = [
                "cash" => [],
                "credit" => [],
                "voucher" => [],
                "delivery" => [],
                "discount" => [],
                "customer" => [],
                "order_finalise_key" => [],
                "order_offer" => [],
            ];

            $request->session()->put('user-session-'.Auth::user()->user_id.'.'.'setupList', $setupList);
           
        }

        $setupList =  $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList');
        return $request;
    }

    public static function SessionCartInitialize($sessionCartList){
        
        $stockList = NULL;

        foreach ($sessionCartList as $sessionCart) {

            $stock = Stock::find($sessionCart['stock_id']);

            $cost = Stock::StockCostDefault($stock->stock_cost);
            $stock_vat = Stock::StockVAT($stock);
            
            $stockList[] = [
                'stock_id' => $stock->stock_id,
                'user_id' => $sessionCart['user_id'],
                'stock_name' => $stock->stock_merchandise['stock_name'],
                'stock_quantity' => $sessionCart['stock_quantity'],
                'stock_cost' => MathHelper::FloatRoundUp($cost, 2),
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

            $cost = Stock::StockCostDefault($stock->stock_cost);
            //$stock_vat = Stock::StockVAT($stock);

            $stockList[] = [
                'stock_id' => $stock->stock_id,
                'user_id' => $receipt['user_id'],
                'stock_name' => $stock->stock_merchandise['stock_name'],
                'stock_quantity' => $receipt['receipt_quantity'],
                'stock_cost' => MathHelper::FloatRoundUp($cost, 2),
                'stock_vat_id' => $stock->stock_merchandise['stock_vat_id'],
                'stock_discount' => json_decode($receipt['receipt_discount'], true), //manually added
                'setting_offer_id' =>  $stock->stock_merchandise['setting_offer_id']
            ];
        } 

        return $stockList;
    }

    //data , stock , loop
    public static function Calculate($data, $stockItem, $loop, $receipt){
        //convert sting to val
        $stock = Stock::find($stockItem['stock_id']);
        $receipt['price'] = $stockItem['stock_cost'] * intval($stockItem['stock_quantity']);
        $receipt['stock_vat_rate'] = null;
        $stockItem['stock_vat_id'] = $stock->stock_merchandise['stock_vat_id'];

        //stock current offer
        if ($stockItem['setting_offer_id']) {
            
            $settingCurrentOffer = Setting::SettingCurrentOffer($stock, array_search('discount', Setting::OfferType()) );
            
            //if there is an offer on stock
            if ($settingCurrentOffer) {
                $receipt['settingCurrentOfferType'] = Setting::SettingCurrentOfferType( $settingCurrentOffer, $receipt['price']);
                $stockCostMin = Stock::StockCostMin( $receipt['settingCurrentOfferType'] );
                
                $receipt['price'] = $stockCostMin['total']['price'];
                $receipt['subTotal'] = $receipt['price'] + $receipt['subTotal'];
            }
            
        }

        //voucher discount // finalise key
        

        //stock vat
        if ($stockItem['stock_vat_id']) {
            $receipt['stock_vat_rate'] = $data['settingModel']->setting_vat[$stockItem['stock_vat_id']]['rate'];
            $receipt['price'] = MathHelper::VAT($receipt['stock_vat_rate'], $receipt['price']);
            
        }

        //add price to subtotal
        $receipt['subTotal'] = $receipt['subTotal'] + $receipt['price'];


        if ($loop->last) {
            
            

            //final discount
             //calculate overall vat
            
            $receipt = Setting::SettingFinaliseKey($data, $receipt);
            $receipt['totalSettingVAT'] = collect($data['settingModel']->setting_vat)->where('deafult', 0)->sum('rate');
            
            $receipt['totalPriceVAT'] = MathHelper::VAT($receipt['totalSettingVAT'], $receipt['subTotal']);
            $receipt['totalPriceFinal'] =  $receipt['totalPriceVAT'] + $receipt['totalPrice'];
        }

        return $receipt;

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
        
        $a = $request->session()->all();
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'cartList');
            $request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'setupList');
            
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
        }

        //return redirect()->route('home.index')->with('success', 'Receipt Empty');
    
    }

    //remove item
    public static function Remove(Request $request, $receipt){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList.'.$receipt);
            
        }

        //return redirect()->route('home.index')->with('success', 'Receipt Removed');
    
    }


    public static function Complete(Request $request, $product){
        
       

        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList', $product);
        }

        //return back()->with('success', 'Receipt Completed');
    
    }


   
}
