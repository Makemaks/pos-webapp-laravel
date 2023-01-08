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

            case 'recover':
                Receipt::Recover($request);
                return redirect()->route('home.index')->with('success', 'Company Successfully Added');
                break;

            case 'suspend':
                Receipt::Suspend($request);
                return redirect()->route('home.index')->with('success', 'Receipt on Suspend');
                break;

            case 'awaiting':
                Receipt::Awaiting($request);
                return redirect()->route('home.index')->with('success', 'Company Successfully Added');
                break;

            case 'empty':
                Receipt::Empty($request);
                return redirect()->route('home.index')->with('success', 'Receipt Empty');
                break;

            case 'remove':
                Receipt::Remove($request, $receipt); //id
                return redirect()->route('home.index')->with('success', 'Receipt Removed');
                break;

            case 'complete':
                Receipt::Complete($request);
                return redirect()->route('home.index')->with('success', 'Receipt Completed');
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

        foreach ($stockList as $stockKey => $stockItem) {
            # code...
        }

        $this->Init();
        
        if ($request->session()->has('user-session-'.Auth::user()->user_id. '.cartList')) {
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
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();


    }

    private function ClearSession(){
        $request->session()->forget('user-session-'.Auth::user()->user_id.'.cartList');

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

    

    private function Data(){
        return[
            'paymentList' => $this->paymentList,
            'paymentModel' => $this->paymentModel,
            'userModel' => $this->userModel,
            'cartList' => $this->sessionCartList,
            'sessionSchemeList' => $this->sessionSchemeList,
            'sessionPlanList' => $this->sessionPlanList,
            'cardList' => $this->cardList,
            'bankList' => $this->bankList,
            'countryList' => $this->countryList,
            'settingModel' => $this->settingModel
        ];
    }


   

}
