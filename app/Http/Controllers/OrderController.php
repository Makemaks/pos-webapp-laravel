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

    public function Index(Request $request)
    {


        $this->init();
        if ($request->session()->has('view') && $request->session()->get('view') == 'till') {
            
            $tillData = $this->settingModel->setting_pos;
            $this->orderList = Receipt::Order('order_setting_pos_id',  1)
                ->orderByDesc('order_id')
                ->groupBy('order_id')
                ->when($request->has('start_date'), function ($query) use ($request) {
                    if ($request->categories != 'all') {
                        $query->whereBetween('order.created_at', [$request->start_date, $request->end_date]);
                    }
                })->paginate(10);
            return view('order.tillIndex', ['data' => $this->Data(), 'tillData' => $tillData]);
        }

        if ($request->session()->has('view') && $request->session()->get('view') == 'bill') {
            
            $tillData = $this->settingModel->setting_pos;
            $this->orderList = Receipt::Order('order_setting_pos_id',  1)
                ->orderByDesc('order_id')
                ->groupBy('order_id')
                ->when($request->has('start_date'), function ($query) use ($request) {
                    if ($request->categories != 'all') {
                        $query->whereBetween('order.created_at', [$request->start_date, $request->end_date]);
                    }
                })->paginate(10);
            return view('order.billIndex', ['data' => $this->Data(), 'tillData' => $tillData]);
        }

        if ($request->session()->has('setting_setting_key')) {
            $request->session()->reflash('order_setting_key');
            $this->store($request);
        }

        if ($request->has('view')) {
            
            $this->orderList = Order::Receipt('receipt_order_id', $request->order_id)
                ->get();
            return view('order.explore', ['data' => $this->Data()]);
        }
        
        $todayDate = Carbon::now()->toDateTimeString();

        $this->orderList = Order::Receipt('order_store_id',  $this->userModel->store_id)
            ->orderByDesc('order_id')
            ->groupBy('order_id')
            ->select('order.*', 'receipt_user_id', 'store_name')
            ->paginate(10);

        return view('order.index', ['data' => $this->Data()]);
    }

    public function Show(Request $request, $order)
    {
        $this->init();
        $this->orderList = Order::Receipt('receipt_order_id', $order)
            ->get();

        return view('order.show', ['data' => $this->Data()]);
    }

    public function Edit(Request $request, $order)
    {
        $this->init();
        $this->request = Receipt::SessionInitialize($request);
        $this->orderList = Order::Receipt('receipt_order_id', $order)
            ->get();


        return view('order.edit', ['data' => $this->Data()]);
    }

    public function Store(Request $request)
    {

        $this->init();
        Order::Process($request, $this->Data());

        return redirect()->route('home.index')->with('success', 'Order Completed');
       // return view('home.index', ['data' => $this->Data()]);
    }

    public function Delete($order)
    {

        Receipt::where('receipt_order_id', $order)->delete();

        Order::Destroy($order);

        return redirect()->route('order.index')->with('success', 'Order Deleted Successfully');
    }

    private function init()
    {
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();
    }

    private function Data()
    {

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

    /**
     * This function update the order status
     * @param Request $request
     * @param int $order
     * @return null
     */
    public function Update(Request $request, $order)
    {
        if ($request->has('order')) {
            foreach ($request->order as $orderData) {
                Order::where('order_id', $orderData['order_id'])->update(['order_status' => $orderData['order_status']]);
            }
            return redirect()->back();
        }

        $a = $request->all();
        //update order - process
        if ($order && $request->has('warehouse_id')) {
            foreach ($request->warehouse_id as $wareHouseKey => $warehouseId) {
                $warehouse = Warehouse::find($request->receipt_quantity[$wareHouseKey]);
                $warehouse_quantity = $warehouse->warehouse_quantity - $request->receipt_quantity[$wareHouseKey];
                Warehouse::where('warehouse_id', $warehouseId)->update(['warehouse_stock_quantity' => $warehouse_quantity]);
                Receipt::where('receipt_id', $request->receipt_id[$wareHouseKey])->update(['receipt_status' => 0]);
            }

            if( count($request->receipt_id) == count($request->warehouse_id)){
                Order::where('order_id', $order)->update(['order_status' => 1]);
            }

            return redirect()->back();
        }
    }
}
