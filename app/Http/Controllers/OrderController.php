<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\Receipt;
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
    private $request;


    public function __construct()
    {
        
        $this->middleware('datetimeMiddleware');
        $this->middleware('auth');
    }

    public function Index(Request $request){

        $this->init();
        $todayDate = Carbon::now()->toDateTimeString();
       

      
         if ($request->session()->has('setting_finalise_key')) {
            $request->session()->reflash('order_finalise_key');
            $this->store($request);
        }

        if($request->has('action') && $request->action == 'stock') {
            $this->init();
          

            $this->orderList = Order::Receipt('receipt_order_id', $request->order_id)
            ->get()
            ->groupBy('receipttable_id');

            return view('order.stock.index', ['data' => $this->Data()]);
        }
       
       
       
      
        $this->orderList = Receipt::Order('order_store_id', $this->userModel->store_id)
        ->orderByDesc('order_id')
        ->groupBy('order_id')
        ->paginate(10);

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
        $this->request = Receipt::SessionInitialize($request);
        $this->orderList = Order::Receipt('receipt_order_id', $order)
        ->get();

        
        return view('order.edit', ['data' => $this->Data()]);   
    }

    public function Store(Request $request){

        $this->init();
        Order::Process($request, $this->Data());
        
        return redirect()->route('home.index')->with('success', 'Order Completed Successfully');
    }


    public function Update(Request $request, $order){

       $requestInput = $request->all();

        if ($request->receipt_quantity && $request->receipt_warehouse_id) {
            foreach ($request->receipt_warehouse_id as $wareHouseKey => $warehouse_id) {
               
                    $warehouse = Warehouse::find($warehouse_id);
                    $warehouse_quantity = $warehouse->warehouse_quantity - $request->receipt_quantity[$wareHouseKey];
                    Warehouse::where('warehouse_id', $warehouse_id)->update(['warehouse_quantity' => $warehouse_quantity]);
            }
            
        }

        return redirect()->back();
    }

    public function Delete($order){

        Receipt::where('receipt_order_id', $order)->delete();

        Order::Destroy($order);

        return redirect()->route('order.index')->with('success', 'Order Deleted Successfully');
    }

    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();
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
            'settingModel' => $this->settingModel,
            'request' => $this->request
        ];
       
    }


    

}
