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

        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();

 
       if ($request['action'] == 'payment') {

            $setting_payment_gateway = collect($this->settingModel->setting_api)->where('type', 1)->first(); 
            $request->session()->flash('STRIPE_KEY', $setting_payment_gateway['key']);

            $stripe = \Stripe\Stripe::setApiKey($setting_payment_gateway['secret']);


            if ($request['total'] > 0) {

               
                $total = MathHelper::FloatRoundUp($request['total'], $decimal = 1);
                $grandTotal = str_replace(".","",$total);

                $setupIntent = \Stripe\PaymentIntent::create([
                    'amount' => $grandTotal,
                    'currency' => 'gbp',
                ]);
            }

            $request->session()->flash('CLIENT_SECRET',  $setupIntent->client_secret);
            $request->session()->flash('GRAND_TOTAL',  $request['total']);

            

            $view = 'receipt.gateway.stripePartial';

            $html = view($view, ['data' => $this->Data()])->render();

       }

       elseif($request['action'] == 'process'){

            $setting_payment_gateway = $this->settingModel->setting_payment_gateway[$request->session()->get('view')]; 

            $stripeIntent = json_decode($request['model']);

            if ($stripeIntent->status == 'succeeded') {

                if (count(json_decode($request['stockList'])) > 0) {
                    $orderInput = [
                        'order_account_id' => $this->userModel->user_account_id,
                        'order_user_id' => $this->userModel->user_id,
                    ];
            
                    $order_id = Order::insertGetId($orderInput);
            
                   
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

                $html = view('stock.index', ['data' => $this->Data()])->render();
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
        
        return view('stock.create',  ['data' => $this->Data()]); 
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {

    $setting_payment_gateway = $this->settingModel->setting_payment_gateway[$request['view']]; 
 

        Stripe\Stripe::setApiKey(env($setting_payment_gateway['secret']));
        Stripe\Charge::create ([
                "amount" => 100 * 150,
                "currency" => "inr",
                "source" => $request->stripeToken,
                "description" => "Making test payment." 
        ]);

        Session::flash('success', 'Payment has been successfully processed.');
        
        return back();
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
}
