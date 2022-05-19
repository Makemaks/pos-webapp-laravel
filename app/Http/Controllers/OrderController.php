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
    private $productList;
    private $storeList;

    private $storeModel;
    private $settingModel;
    private $schemeList;
    private $personModel;
   
    private $orderModel;
   


    public function __construct()
    {
      
        $this->middleware('auth');
    }

    public function Index(){
      
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        $todayDate = Carbon::now()->toDateTimeString();
        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();
        
      

        $this->orderList = Store::Sale('store_id',  $this->userModel->store_id)
        ->groupBy('order_id')
        ->paginate(20);

        return view('order.index', ['data' => $this->Data()]);   
      
    }

    public function Show(Request $request, $order){
        $this->orderList = Order::Receipt()
        ->where('receipt_order_id', $order)
        ->get()
        ->groupBy('receipt_product_id');

        $this->userModel = User::Person('user_person_id', Auth::user()->user_person_id)->first();
           
        $this->schemeList = Scheme::Store('scheme_store_id', $this->userModel->store_id)->get(); 
        
        $this->settingModel = Setting::Store()
        ->where('setting_store_id', $this->userModel->store_id)
        ->first();

        return view('order.show', ['data' => $this->Data()]);   
    }

    public function Edit(Request $request, $order){
        $this->orderList = Order::Receipt()
        ->where('receipt_order_id', $order)
        ->get()
        ->groupBy('receipt_product_id');

        $this->userModel = User::Person('user_person_id', Auth::user()->user_person_id)->first();
           
        $this->schemeList = Plan::Scheme('scheme_store_id', $this->userModel->store_id)->get(); 
        
        $this->settingModel = Setting::Store()
        ->where('setting_store_id', $this->userModel->store_id)
        ->first();

        
        return view('order.edit', ['data' => $this->Data()]);   
    }

    public function Store(Request $request){

        
        $requestInput = $request->all()['cart'];
        $authenticatedUser = Auth::user();

        $orderInput = [
            'store_store_id' => $authenticatedUser->store_id,
            'user_person_id' => $authenticatedUser->user_id,
            'status' => '',
            'type' => ''
        ];

        $orderInput = DatabaseHelper::MergeArray($orderInput, DatabaseHelper::Timestamp());
        $this->orderModel = Order::create($orderInput);

        $productListID = Arr::pluck($requestInput, 'product_id');
        $this->productList = Product::find($productListID);
       
        foreach ( $this->productList as $product) {
            $receiptInput[] = [
                'order_order_id' => $this->orderModel->order_id,
                'product_product_id' => $product->product_id,
            ];

            $orderInput = DatabaseHelper::MergeArray($orderInput, DatabaseHelper::Timestamp());
        }

        //decrement product from table
        $productCountList= collect($productListID);
        foreach( $productCountList as $productKey => $productValue){
            Product::QuantityDecrease($productKey, $productValue);
        }

        Receipt::Insert($receiptInput);
        
        return view('cart.index' ,['data' => $this->Data()]);
    }

    public function Delete($order){

        Receipt::where('receipt_order_id', $order)->delete();

        Order::Destroy($order);

        return redirect()->route('index')->with('success', 'Order Deleted Successfully');
    }

    private function Data(){

        return [
            'authenticatedUser' => $this->authenticatedUser,
            'orderList' => $this->orderList,
            'productList' => $this->productList,
            'schemeList' => $this->schemeList,
            'userModel' => $this->userModel,
            'settingModel' => $this->settingModel
        ];
       
    }
}
