<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Scheme;
use App\Models\Plan;
use App\Models\User;
use App\Models\Stripe;
use App\Models\Store;
use App\Models\Person;
use App\Models\Order;

class ReceiptManagerController extends Controller
{
    private $storeModel;
    private $cartList;
    private $sessionCartList;
    private $schemeList;
    private $planList;
    private $userModel;
    private $productList;
    private $userList;
    private $orderModel;
    private $currency;
    private $key;
    private $stripe;


    public function __construct()
    {
        $this->key = env('STRIPE_SECRET', false);
        $this->currency = env('STRIPE_CURRENCY', false);
        //$this->stripe = new \Stripe\StripeClient($this->key);

        $this->middleware('auth');
        $this->middleware('cartMiddleware');
    }

    public function Index(Request $request){

        if ($request->session()->has('user-session-'.Auth::user()->user_id)) {
            $this->sessionCartList = $request->session()->get('user-session-'.Auth::user()->user_id. '.cartList');            
            $this->productList = Product::get();  
           
            $this->userModel = User::Person('user_id', Auth::user()->user_id)->first();
            
            $this->schemeList = Scheme::List('schemetable_id', Auth::user()->user_id)
            ->where('schemetable_type', 'user')
            ->get();

            $this->planList = Plan::List('plan_account_id',  $this->userModel->person_account_id)
            ->paginate(20);

            $this->userList = User::Store('person_account_id', $this->userModel->person_account_id)
            ->orderBy('person_firstname')
            ->get();
        }

        $html = view('receipt-manager.index', ['data' => $this->Data()])->render();
        return response()->json( [
            'success' => true, 'view' => $html] );
       
    }
    

    public function Recover(Request $request, $receipt){

        if ($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList')) {
            
            $this->sessionCartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList.'.$receipt); 
            $request->session()->put('user-session-'.Auth::user()->user_id. '.cartList', $this->sessionCartList);       
        }

        return redirect()->route('home.index');
    }


    public function Suspend(Request $request){

        if($request->session()->has('user-session-'.Auth::user()->user_id)){
            //remove session
            $cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList');
            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList', $cartList);
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
        }

        return back()->with('success', 'Receipt on Suspend');
      
    }

    public function Awaiting(Request $request){

        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList')){
            //remove session
            $this->sessionCartList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList');
        }

        return view('receipt-manager.awaiting.index', ['data' => $this->Data()]);
      
    }

    public function Empty(Request $request){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $request->session()->forget('user-session-'.Auth::user()->user_id.'.'.'cartList');
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList',[]);
        }

        return redirect()->route('home.index')->with('success', 'Receipt Empty');
      
    }

    public function Remove(Request $request, $receipt){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartAwaitingList.'.$receipt);
        }

        return redirect()->route('home.index')->with('success', 'Receipt Removed');
      
    }


    public function Complete(Request $request, $product){
        
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList', $product);
        }

        return back()->with('success', 'Receipt Completed');
      
    }

    public function scheme(Request $request, $product){

    }

    private function Data(){

        return[
            'cartList' => $this->cartList,
            'sessionCartList' => $this->sessionCartList,
            'schemeList' => $this->schemeList,
            'planList' => $this->planList,
            'userList' => $this->userList,
            'userModel' => $this->userModel
        ];
    }
}
