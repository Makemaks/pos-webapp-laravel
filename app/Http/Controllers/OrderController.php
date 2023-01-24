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



    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Index(Request $request)
    {

        if ($request->session()->has('view') && $request->session()->get('view') == 'till') {
            $this->init();
            $tillData = $this->settingModel->setting_pos;
            $userOrder = Order::pluck('order_user_id')->toArray();
            $clerks = User::whereIn('user_id',$userOrder)->get();
            $stocks = Stock::get();

            if(isset($request->department)) {
                foreach($stocks as $stock) {
                    if($stock->stock_merchandise['category_id'] == $request->department) {
                        $stockStoreId = $stock->stock_store_id;
                        break;
                    }
                }
            }
            $this->orderList = Receipt::Order('order_setting_pos_id',  1)
                ->orderByDesc('order_id')
                ->groupBy('order_id')
                ->when($request->has('start_date'), function ($query) use ($request) {
                    if ($request->categories != 'all') {
                        $query->whereBetween('order.created_at', [$request->start_date, $request->end_date]);
                    }
                })
                ->when($request->has('clerk'), function ($query) use ($request) {
                    if ($request->categories != 'all') {
                        $query->where('order.order_user_id', $request->clerk);
                    }
                })
                ->when($request->has('department'), function ($query) use ($request) {
                    if ($request->categories != 'all' && isset($stockStoreId)) {
                        $query->where('order.order_store_id', $stockStoreId);
                    }
                })
                ->paginate(10);
            return view('order.tillIndex', ['data' => $this->Data(), 'tillData' => $tillData , 'clerks' => $clerks,'stocks'=> $stocks]);
        }

        if ($request->session()->has('view') && $request->session()->get('view') == 'bill') {
            $this->init();
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
            $this->init();
            $this->orderList = Order::Receipt('receipt_order_id', $request->order_id)
                ->get();
            return view('order.availability', ['data' => $this->Data()]);
        }
        $this->init();
        $todayDate = Carbon::now()->toDateTimeString();

        $this->orderList = Receipt::Order('stock_store_id',  1)
            ->orderByDesc('order_id')
            ->groupBy('order_id')
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
        $this->orderList = Order::Receipt('receipt_order_id', $order)
            ->get();


        return view('order.edit', ['data' => $this->Data()]);
    }

    public function Store(Request $request)
    {

        $this->init();
        Order::Process($request, $this->Data());

        return view('home.index', ['data' => $this->Data()]);
    }

    public function Delete($order)
    {

        Receipt::where('receipt_order_id', $order)->delete();

        Order::Destroy($order);

        return redirect()->route('index')->with('success', 'Order Deleted Successfully');
    }

    private function init()
    {
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();
        $this->settingModel = Setting::where('setting_account_id', $this->userModel->store_id)->first();
    }

    private function ProcessOrder()
    {


        foreach ($this->sessionCartList as $cart) {
        }
    }




    private function Data()
    {

        return [
            'authenticatedUser' => $this->authenticatedUser,
            'orderList' => $this->orderList,
            'stockList' => $this->stockList,
            'schemeList' => $this->schemeList,
            'userModel' => $this->userModel,
            'settingModel' => $this->settingModel
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
    }
}
