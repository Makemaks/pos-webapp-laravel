<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use App\Models\Scheme;
use App\Models\Plan;
use App\Models\Person;
use App\Models\Setting;

class OrderController extends Controller
{

    private $authenticatedUser;
    private $orderList;
    private $stockList;
    private $storeList;

    private $storeModel;
    private $settingModel;
    private $schemeList;
    private $userModel;
   
    private $orderModel;
   


    public function __construct()
    {
      
        $this->middleware('auth');
    }

    public function Index(Request $request){
      
        if ($request->has('order_finalise_key')) {
            $this->store($request);
        }

        $this->init();
        $todayDate = Carbon::now()->toDateTimeString();
       
        $this->orderList = Store::Sale('store_id',  $this->userModel->store_id)
        ->groupBy('order_id')
        ->paginate(20);

        return view('order.index', ['data' => $this->Data()]);   
      
    }

    public function Show(Request $request, $order){
        $this->init();
        $this->orderList = Order::Receipt('receipt_order_id', $order)
        ->get();

        return view('order.show', ['data' => $this->Data()]);   
    }

    public function Edit(Request $request, $order){
        $this->init();
        $this->orderList = Order::Receipt('receipt_order_id', $order)
        ->get();

        
        return view('order.edit', ['data' => $this->Data()]);   
    }

    public function Store(Request $request){

        $this->init();
        $receipt = [];
        //get receipt stock
        if(Session::has('user-session-'.Auth::user()->user_id. '.cartList')){

            $sessionCartList = Session::get('user-session-'.Auth::user()->user_id. '.cartList');
            $stockList = Receipt::SessionDisplay($sessionCartList);
        }

        $this->userModel = User::Person('user_person_id', Auth::user()->user_person_id)
            ->first();

        //store order
        $orderData = [

            'order_user_id' => $this->userModel->user_id,
            'order_store_id' => $this->userModel->user_store_id,
            'ordertable_id' => $this->userModel->person_id,
            'ordertable_type' => 'Person',
            'order_status' => 0,
            'order_offer' => Session::get('user-session-'.Auth::user()->user_id. '.offerList'),
            'order_type' =>  Order::ProcessOrderType($this->userModel),
            'order_finalise_key' => '',
            
            
            'order_setting_pos_id' => 1
           
        ];

        $orderData = DatabaseHelper::MergeArray($orderData, DatabaseHelper::Timestamp());
        $orderID = Order::insertGetId($orderData);

        //store receipt
        foreach ($stockList as $stockKey => $stockItem) {
            $receipt = Receipt::Calculate( $data, $stockItem, $loop, $receipt );

            $receiptData = [
                'receipt_stock_id' => $stockItem['stock_id'],
                'receipt_order_id' =>  $orderID,
                'receipt_user_id' => $stockItem['user_id'],
               ];
    
                //decrement stock from table
            Stock::QuantityDecrease($stockKey, $stockValue);
            $receiptData = DatabaseHelper::MergeArray($receiptData, DatabaseHelper::Timestamp());
            Receipt::insert($receiptData);
        }
       
        
        return view('home.index' ,['data' => $this->Data()]);
    }

    public function Delete($order){

        Receipt::where('receipt_order_id', $order)->delete();

        Order::Destroy($order);

        return redirect()->route('index')->with('success', 'Order Deleted Successfully');
    }

    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();
    }

    private function ProcessOrder(){
       

        foreach( $this->sessionCartList as $cart){
           
           
        }
    }

    private function Data(){

        return [
            'authenticatedUser' => $this->authenticatedUser,
            'orderList' => $this->orderList,
            'stockList' => $this->stockList,
            'schemeList' => $this->schemeList,
            'userModel' => $this->userModel,
            'settingModel' => $this->settingModel
        ];
       
    }
}
