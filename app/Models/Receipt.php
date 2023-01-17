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
        $requestInput = ['setting_stock_price_level' => 1, 'setting_stock_price_group' => 1];

        if ( count($request->all()) > 0) {
            $requestInput = $request->all();
        }


        if ( $request->session()->has('user-session-'.Auth::user()->user_id.'.setupList') == false) {
            $setupList = [
                'customer' => [],
                'setting_key' => [],
                'setting_key_total' => 0,
                'stock_setting_offer' => [],
                'stock_setting_key' => [],
                'stock_setting_key_total' => 0,
                'stock_price_offer' => 0,
                'stock_setting_offer_total' => 0,
                'stock_price' => 0,
                'stock_setting_vat' => [],
                'stock_vat_rate' => 0,
                'stock_vat_rate_total' => 0,
                'stock_vat_amount_total' => 0,
                'setting_offer' => [],
                'order_vat_amount_total' => 0,
                'order_price_total' => 0,
                'order_sub_total' => 0,
                'order_setting_key' => [],
                'order_setting_key_total' => 0,
                'requestInput' => $requestInput,
            ];
            
            $request->session()->put('user-session-'.Auth::user()->user_id.'.setupList', $setupList);
           
        }

        $setupList =  $request->session()->get('user-session-'.Auth::user()->user_id.'.setupList');

        return $setupList;
    }

    public static function SessionCartInitialize($cartList, $setupList){
        
        $stockList = [];

        foreach ($cartList as $sessionCart) {

            $stock = Stock::find($sessionCart['stock_id']);
            $store = Store::find($sessionCart['store_id']);
         
            $stockList[] = Stock::StockInitialize($stock, $store, $setupList);

        } 

        return $stockList;
    }

    public static function ReceiptCartInitialize($orderList){
        //reinitialise session values for cart
        $receipt_setting_vat = NULL;
        $stockList = [];
        
        foreach ($orderList as $receipt) {
            
         /*   if ($receipt->receipt_setting_vat) {
                $receipt_setting_vat = array_sum($receipt->receipt_setting_vat);
           } */

           $stock = Stock::find($sessionCart['stock_id']);
           $store = Store::find($sessionCart['store_id']);
        
           $stockList[] = Stock::StockInitialize($stock, $store, $setupList);
        } 

        return $stockList;
    }

    //data , stock , loop
    public static function Calculate($data, $stockItem, $loop){
        //convert sting to val
        $data['setupList']['stock_vat_rate'] = 0;
        $data['setupList']['setting_key_total'] = 0;
        $stock = Stock::find($stockItem['stock_id']);
       
        if ($loop->first) {
            
            $data['setupList']['order_sub_total'] = 0;
            $data['setupList']['order_vat_amount_total'] = 0;
            $data['setupList']['order_price_total'] = 0;
            $data['setupList']['stock_vat_rate_total'] = 0;
            $data['setupList']['stock_vat_amount_total'] = 0;
            $data['setupList']['stock_setting_offer_total'] = 0;
        }

        //add the stock_price with offer amount to quantity
        $stock_price_processed = Stock::StockPriceQuantity( $data['setupList']['stock_price_offer'], $stockItem['stock_quantity']);
        $data['setupList']['stock_price_offer'] = $stock_price_processed;
        
        //stock setting key
        if ( count($stockItem['stock_setting_key'])  > 0 ) {
            //process  setting_key_total
            $data['setupList'] = Setting::SettingKey( $data['setupList'], $stockItem['stock_setting_key'] );
            $data['setupList']['stock_setting_key'] = $stockItem['stock_setting_key'];
            $data['setupList']['stock_setting_key_total'] = $data['setupList']['stock_setting_key_total'] + $data['setupList']['setting_key_total'];
        }

        //stock vat
        if ( count($stockItem['stock_setting_vat']) > 0 ) {
           
            $data['setupList']['order_sub_total'] = $data['setupList']['order_sub_total'] + $stock_price_processed;
            $data['setupList']['stock_vat_rate'] = collect($stockItem['stock_setting_vat'])->sum('rate');
            
            //All stock vat rate
            $data['setupList']['stock_vat_rate_total'] =  $data['setupList']['stock_vat_rate_total'] + $data['setupList']['stock_vat_rate'];
            $setting_offer_total = MathHelper::VAT($data['setupList']['stock_vat_rate'], $stock_price_processed);
            $stock_price_processed = $stock_price_processed + $setting_offer_total;
            $data['setupList']['stock_vat_amount_total'] = $data['setupList']['stock_vat_amount_total'] + $setting_offer_total;
          
        }else{
           
            $data['setupList']['order_sub_total'] = $data['setupList']['order_sub_total'] + $stock_price_processed;
            $setting_vat_rate = collect($data['settingModel']->setting_vat)->where('default', 0)->first()['rate'];
            $setting_offer_total = MathHelper::VAT($setting_vat_rate, $stock_price_processed);
            $stock_price_processed = $stock_price_processed + $setting_offer_total;

            $data['setupList']['order_vat_amount_total'] = $data['setupList']['order_vat_amount_total'] + $setting_offer_total;
          
        }

        $data['setupList']['order_price_total'] = $data['setupList']['order_price_total'] + $stock_price_processed;

        //setting_key
        if ($loop->last && count($data['setupList']['order_setting_key']) > 0) {
            
            //order setting key
            if ( count($data['setupList']['order_setting_key'])  > 0 || count($stockItem['stock_setting_key'])  > 0) {
                $data['setupList'] = Setting::SettingKey( $data['setupList'], $data['setupList']['order_setting_key'] );
               
                $data['setupList']['order_setting_key_total'] = $data['setupList']['order_setting_key_total'] + $data['setupList']['setting_key_total'];
            }

            $data['setupList']['order_setting_key_total']= $data['setupList']['order_setting_key_total'] + $data['setupList']['stock_setting_key_total'];
           
        }

        return $data;

    }


    
     /* 
        Session Manager 
        Used to manipulate session data
    */
    public static function Recover(Request $request, $receipt){

        if ($request->session()->has('user-session-'.Auth::user()->user_id.'.awaitingCartList')) {
            
            $this->cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.awaitingCartList.'.$receipt); 
            $request->session()->put('user-session-'.Auth::user()->user_id. '.cartList', $this->cartList);       
        }

        //return redirect()->route('home.index');
       
    }


    public static function Suspend(Request $request){

        if($request->session()->has('user-session-'.Auth::user()->user_id)){
            //remove session
            $cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.cartList');
            $request->session()->push('user-session-'.Auth::user()->user_id.'.awaitingCartList', $cartList);
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
        }

        //return back()->with('success', 'Receipt on Suspend');
    
    }

    public static function Awaiting(Request $request){

        if($request->session()->has('user-session-'.Auth::user()->user_id.'.awaitingCartList')){
            //remove session
            $this->cartList = $request->session()->get('user-session-'.Auth::user()->user_id.'.awaitingCartList');
        }

        //return view('receipt-manager.awaiting.index', ['data' => $this->Data()]);
    
    }

    public static function Empty(Request $request){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.cartList')){
            //remove session
            $request->session()->forget('user-session-'.Auth::user()->user_id.'.cartList');
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
        }

        if($request->session()->has('user-session-'.Auth::user()->user_id.'.setupList')){
            $request->session()->forget('user-session-'.Auth::user()->user_id.'.setupList');
        }
    
        return $request;
    }

    //remove item
    public static function Remove(Request $request, $receipt){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.awaitingCartList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.awaitingCartList.'.$receipt);
            
        }

        return $request;
    
    }


    public static function Complete(Request $request, $product){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.cartList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.cartList', $product);
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
