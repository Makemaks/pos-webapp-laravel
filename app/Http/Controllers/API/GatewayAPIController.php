<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Helpers\MathHelper;


use App\Models\Stock;
use App\Models\Order;
use App\Models\User;
use App\Models\Setting;
use App\Models\Receipt;

class GatewayAPIController extends Controller
{
    private $userModel;
    private $stockList;
    private $storeList;
    private $stockModel;
    private $categoryList;
    private $settingModel;
    private $fileModel;
    private $sessionStockList;
    

    public function __construct()
    {
        $this->middleware('sessionMiddleware');
    }
    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index(Request $request)
   {

        //composer require stripe/stripe-php

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        $stockCount = 0;
        $this->userModel = User::Person('user_person_id', Auth::user()->user_person_id)->first();
        $error = "";

        $this->settingModel = Setting::where('settingtable_id', Auth::user()->store_id)->first();

 
       if ($request['action'] == 'payment') {

            $setting_payment_gateway = collect($this->settingModel->setting_api)->where('type', 0)->first(); 
            $request->session()->flash('STRIPE_KEY', $setting_payment_gateway['key']);

            $stripe = \Stripe\Stripe::setApiKey($setting_payment_gateway['secret']);
            
            $priceVAT = $this->Process()['priceVAT'];
            
    

            if ($priceVAT > 0) {

                //$total = MathHelper::FloatRoundUp($request['total'], $decimal = 1);
                //$grandTotal = str_replace(".","",$total);

                $grandTotal =  MathHelper::StripeRoundUp($request['total']);

                $setupIntent = \Stripe\PaymentIntent::create([
                    'amount' => $grandTotal,
                    'currency' => 'gbp',
                ]);
            }

            $request->session()->flash('CLIENT_SECRET',  $setupIntent->client_secret);
            $request->session()->flash('GRAND_TOTAL',  $request['total']);

            

            $view = 'receipt.gateway.stripePartial';

            $html = view($view, ['html' => $this->Data()])->render();

       }

       elseif($request['action'] == 'process'){

           

            $stripeIntent = json_decode($request['model']);

            if ($stripeIntent->status == 'succeeded') {

                if (Session::has('user-session-'.Auth::user()->user_id. '.cartList')) {

                    
                    $orderInput = [
                        'order_account_id' => $this->userModel->user_account_id,
                        'order_user_id' => $this->userModel->user_id,
                    ];
            
                    $order_id = Order::insertGetId($orderInput);
            
                   
                    if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList')){
                        //remove session
                        $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'awaitingCartList.'.$receipt);
                    }

                    $this->stockList = Stock::whereIn('stock_id', json_decode($request['stockList']))->get();
                    $this->sessionStockList = collect(json_decode($request['stockList']));
                    $quantity = $this->sessionStockList['sessionStockList']->countBy()->pull($stock->stock_id);
                   
                    foreach ( $this->stockList as $stock) {
                        $quantity = $this->sessionStockList['sessionStockList']->countBy()->pull($stock->stock_id);

                        $receiptInput[] = [
                            'receipt_order_id' => $order_id,
                            'receipttable_id' => $stock->stock_id,
                            'receipttable_type' => 'Stock',
                            'receipt_user_id' =>  $this->userModel->user_id,
                            $quantity => $quantity
                        ];
            
                       
                    }
            
                    //decrement product from table
                   
                    foreach( $this->stockList as $stock){
                        $stock_quantity = $stock->stock_quantity[0];
                        

                        $stock_quantity_list = $stock->stock_quantity;
                        $stock_quantity--;
                        $stock_quantity_list[0] = $stock_quantity;
                        $stock->stock_quantity = $stock_quantity_list;
                        $stock->update();
                    }
            
                    Receipt::Insert($receiptInput);
                }

                $this->stockList = Stock::List('stock_account_id', $this->userModel->user_account_id)
                ->where('stock_group_id', $request['view'])
                ->latest('stock.created_at')
                ->get();

                $html = view('stock.index', ['html' => $this->Data()])->render();
            }else{
                $error = 'Payment Failed';

            }

       }
    
      
      
      
       return response()->json( [
           'success' => true, 
           'view' => $html, 
           'stockCount' => $stockCount, 
           'user_type' => Auth::user()->user_type,
           'error' => $error
           ] );
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
        $this->stockModel = new Shop();
        
        return view('stock.create',  ['html' => $this->Data()]); 
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {

   
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
       //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
       //
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, $id)
   {
       //
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
       //
   }

   private function Data(){
    return [
           
        'userModel'=> $this->userModel,
         'categoryList' => $this->categoryList,
         'stockList' => $this->stockList,
         'stockModel' => $this->stockModel,
         'settingModel' =>  $this->settingModel,
         'fileModel' => $this->fileModel,
         'storeList' => $this->storeList,
         'sessionStockList' => $this->sessionStockList
     ];
   }


   private function Process(){

        $receipt = [];
        $receipt['priceVAT'] = 0;
        $receipt['totalPrice'] = 0;
        $receipt['discountTotal'] = 0;
        $orderData = [];
        $receiptData = [];

        if($request->session()->has('user-session-'.Auth::user()->user_id. '.cartList')){

            $sessionCartList = $request->session()->get('user-session-'.Auth::user()->user_id. '.cartList');
            //$stockList = Receipt::SessionDisplay($sessionCartList);
        }

        foreach ($sessionCartList as $key => $sessionCart) {
            
            
            if($key >= count($sessionCartList)){
                $loop->last = true;
            }

            if (array_key_exists('receipt_discount', $sessionCartList)) {
                    $receiptData += $sessionCartList['receipt_discount'];
            }
        
            $receipt = Receipt::Calculate($this->Data(), $sessionCartList, $loop, $receipt);
        
        }

        return $receipt;
   }


}
