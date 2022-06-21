<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

use App\Models\Setting;
use App\Models\Product;
use App\Models\Company;
use App\Models\User;
use App\Models\Stripe;
use App\Models\Store;
use App\Models\Person;
use App\Models\Order;
use App\Models\Receipt;

use App\Helpers\CurrencyHelper;

class ReceiptController extends Controller
{

  
    private $paymentList;
    private $userModel;
    private $paymentModel;
    private $storeModel;
    private $cardList;
    private $bankList;  
    private $countryList;  
    private $sessionCartList;
    private $sessionSchemeList;
    private $sessionPlanList;
    private $setting_stripe_key;
    private $setting_stripe_secret;
    private $stripe;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(){

       /*  $this->middleware('auth');
        $this->middleware('cartMiddleware'); */
    }

    public function index(Request $request)
    {
       
         $this->init();

         switch ($request->view):
            case 'person':
                return redirect()->route('person.index');
                break;

            case 'empty':
                $this->Empty($request);
                break;

            default:
                echo "i is not equal to 0, 1 or 2";
        endswitch;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

       /*  $this->validate($request, [
           
            'receipt_user_id' => 'required',   

        ], [
            'required' => 'This field is required',
        ]); */

        $this->Init();
        
        if ($request->session()->has('user-session-'.Auth::user()->user_id)) {
            $this->sessionCartList = $request->session()->get('user-session-'.Auth::user()->user_id. '.cartList');            
        }


        $this->userModel = User::Person('user_id', $request['receipt_user_id'])
        ->first();


        if (User::UserType()[Auth::user()->user_type] == 'Customer') {
            $this->SetUpStripe();
        }else{
            $data = $this->Data();
        }

        return view('payment.create', ['data' => $data, 'receipt_user_id' => $request['receipt_user_id']]);
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->session()->has('user-session-'.Auth::user()->user_id)) {
            $this->sessionCartList = $request->session()->get('user-session-'.Auth::user()->user_id. '.cartList');            
        
            $this->Init();
            $this->userModel = User::Person('user_id', $request['receipt_user_id'])
            ->first();


            if ($request->has('payment_method_id')) {
                $this->ProcessOrder();
            } 
            elseif ($request->has('Accepted')){
                $this->ProcessOrder();
                return redirect()->route('home.index');
            }
            elseif($request->has('Declined')){
                return back()->with('error', 'Payment Failed');
            }

        }
        
      
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

    private function Init(){

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

        $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();
        
        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();


       /* if ($this->userModel->person_stripe_customer_id == NULL) {
            $stripe_customer = $this->stripe->customers->create([
              'email' => Auth::user()->email
            ]);

            Person::where('person_id', $this->userModel->person_id)->update(['stripe_customer_id' => $stripe_customer->id]);
            $this->userModel = User::Person('user_person_id', Auth::user()->user_person_id)
            ->first();

        } */


    }

    private function ClearSession(){
        $request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'cartList');
        $request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'scemeList');
        $request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'planList');

        $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
    }

    Private function SetUpStripe(){
       
        $this->stripe = new \Stripe\StripeClient($this->settingModel->setting_stripe_secret);

        $setupIntent = $this->stripe->setupIntents->create([
            'payment_method_types' => ['card'],
            'customer' => $this->userModel->person_stripe_customer_id
        ]);


        $data = $this->Data();
        $data['setupIntent'] = $setupIntent;

    }

    Private function ProcessStripe(){
        try {
                
            $payment_intent = $this->stripe->paymentIntents->create([
              'amount' => Order::Total($this->sessionCartList) * 100,
              'currency' => CurrencyHelper::IntCurrency(),
              'customer' => $this->userModel->person_stripe_customer_id,
              'payment_method' => $request['payment_method_id'],
              'off_session' => true,
              'confirm' => true,
            ]);

            if ($payment_intent) {
              
                $this->ProcessOrder();
                $this->ClearSession();
                return redirect()->route('home.index')->with('success', 'Payment Successful');
            } 
            
        } 
            
        catch (\Stripe\Exception\CardException $e) {
            // Error code will be authentication_required if authentication is needed
            echo 'Error code is:' . $e->getError()->code;
            $payment_intent_id = $e->getError()->payment_intent->id;
            $payment_intent = $this->stripe->paymentIntents->retrieve($payment_intent_id);

            return back()->with('error', 'Payment Failed');
        }
    }

    private function ProcessOrder(){
        $orderData = [
          
            'ordertable_id' => $this->userModel->person_id,
            'ordertable_type' => 'Person',
            
            'order_status' => 0,
            'order_type' => $request->order_type,
            'stripe_payment_intent_id' =>  $payment_intent,
            'order_account_id' => $this->userModel->person_account_id,

           
        ];

        $orderID = Order::insertGetId($orderData);

        foreach( $this->sessionCartList as $cart){
           
           $receipt = [
            'receipt_product_id' => $cart['product'],
            'receipt_order_id' =>  $orderID,
            'receipt_user_id' => $request['receipt_user_id'],
            'receipt_plan_id' => $cart['plan'],
           ];

            Receipt::insert($receipt);
        }
    }

    private function Data(){
        return[
            'paymentList' => $this->paymentList,
            'paymentModel' => $this->paymentModel,
            'userModel' => $this->userModel,
            'sessionCartList' => $this->sessionCartList,
            'sessionSchemeList' => $this->sessionSchemeList,
            'sessionPlanList' => $this->sessionPlanList,
            'cardList' => $this->cardList,
            'bankList' => $this->bankList,
            'countryList' => $this->countryList,
            'settingModel' => $this->settingModel
        ];
    }


    /* 
        Session Manager 
        Used to manipulate session data
    */
   private function Recover(Request $request, $receipt){

        if ($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList')) {
            
            $this->sessionCartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList.'.$receipt); 
            $request->session()->put('user-session-'.Auth::user()->user_id. '.cartList', $this->sessionCartList);       
        }

        return redirect()->route('home.index');
    }


   private function Suspend(Request $request){

        if($request->session()->has('user-session-'.Auth::user()->user_id)){
            //remove session
            $cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList');
            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList', $cartList);
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
        }

        return back()->with('success', 'Receipt on Suspend');
      
    }

   private function Awaiting(Request $request){

        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList')){
            //remove session
            $this->sessionCartList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList');
        }

        return view('receipt-manager.awaiting.index', ['data' => $this->Data()]);
      
    }

   private function Empty(Request $request){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'cartList');
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
        }

        return redirect()->route('home.index')->with('success', 'Receipt Empty');
      
    }

    //remove item
   private function Remove(Request $request, $receipt){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList.'.$receipt);
        }

        return redirect()->route('home.index')->with('success', 'Receipt Removed');
      
    }


   private function Complete(Request $request, $product){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList', $product);
        }

        return back()->with('success', 'Receipt Completed');
      
    }

}
