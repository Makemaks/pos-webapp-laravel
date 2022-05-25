<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Helpers\DateTimeHelper;
use App\Models\Store;
use App\Models\User;
use App\Models\Order;
use App\Models\Receipt;
use App\Models\Expense;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class DashboardController extends Controller
{


    private $categoryList;
    private $storeList;
    private $expenseList;
    private $orderList;
    private $storeModel;
    private $personModel;
    private $settingModel;
    private $paymentModel;
    private $cartItem = [];
    private $cartAwaitingList = [];
    private $authenticatedUser;
    private $accountList;
    private $pdfView;
    private $csvView;



    public function Index(Request $request)
    {


        // put in session for first 3 if statements. 
        $user_id = null;
        $started_at = '0000-00-00 00:00:00';
        $ended_at = Carbon::now()->toDateTimeString();

        $this->authenticatedUser = Auth::user();

        if ($request->user_id) {

            // searching by user, date or user , date_period
            $user_id = $request->user_id;
            $this->authenticatedUser = User::Person('user_id', $user_id)->first();
        }

        if ($request->date_period) {

            // searching by date and date_period
            $date_period = $request->date_period;

            if ($date_period === 'Today') {
                $started_at = Carbon::now()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'Yesterday') {
                $started_at = Carbon::yesterday()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::yesterday()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'This Week') {
                $started_at = Carbon::now()->startOfWeek()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfWeek()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'Last Week') {
                $started_at = Carbon::now()->startOfWeek()->subWeek()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfWeek()->subWeek()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'This Month') {
                $started_at = Carbon::now()->startOfMonth()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfMonth()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'Last Month') {
                $started_at = Carbon::now()->startOfMonth()->subMonth()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfMonth()->subMonth()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'This Quarter') {
                $started_at = Carbon::now()->startOfQuarter()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfQuarter()->setTime(23, 59, 59)->toDateTimeString();
            }

            if ($date_period === 'Last Quarter') {
                $started_at = Carbon::now()->startOfQuarter()->subQuarter()->setTime(0, 0, 0)->toDateTimeString();
                $ended_at = Carbon::now()->endOfQuarter()->subQuarter()->setTime(23, 59, 59)->toDateTimeString();
            }
        }

        if ($request->ended_at && $request->started_at) {

            // searching by date
            $started_at = $request->started_at;
            $ended_at = $request->ended_at;
        }

        $this->userModel = User::Account('account_id', $this->authenticatedUser->user_account_id)->first();

        if ($request->user_id) {
            $this->orderList =  Store::Order('store_id',  $this->userModel->store_id)->whereBetween('order.created_at', [$started_at, $ended_at])->where('user_id', $user_id)->get();
        } else {
            $this->orderList = Store::Order('store_id',  $this->userModel->store_id)->whereBetween('order.created_at', [$started_at, $ended_at])->get();
        }

        $this->orderSettingList = Store::Setting('store_id',  $this->userModel->store_id)->whereBetween('order.created_at', [$started_at, $ended_at])->get();

        $this->eat_in_eat_out = Order::where('order_store_id', $this->userModel->store_id)->orderBy('order.created_at', 'desc')->whereBetween('order.created_at', [$started_at, $ended_at])->get();

        if ($request->user_id) {
            $this->orderHourly = Order::HourlyReceipt()
                ->where('order_store_id',  $this->userModel->store_id)
                ->orderBy('order_id')->whereBetween('order.created_at', [$started_at, $ended_at])->where('user_id', $user_id)
                ->get();
        } else {
            $this->orderHourly = Order::HourlyReceipt()
                ->where('order_store_id',  $this->userModel->store_id)
                ->orderBy('order_id')->whereBetween('order.created_at', [$started_at, $ended_at])
                ->get();
        }

        if ($request->user_id) {
            $this->orderListASC = Order::Receipt()
                ->where('order_store_id',  $this->userModel->store_id)
                ->orderBy('order_id', 'desc')->whereBetween('order.created_at', [$started_at, $ended_at])->where('user_id', $user_id)
                ->get();
        } else {
            $this->orderListASC = Order::Receipt()
                ->where('order_store_id',  $this->userModel->store_id)
                ->orderBy('order_id', 'desc')->whereBetween('order.created_at', [$started_at, $ended_at])
                ->get();
        }

        if ($request->user_id) {
            $this->orderListLimited100 = Store::Sale('store_id',  $this->userModel->store_id)->limit(100)->whereBetween('order.created_at', [$started_at, $ended_at])->where('user_id', $user_id)->get();
        } else {
            $this->orderListLimited100 = Store::Sale('store_id',  $this->userModel->store_id)->limit(100)->whereBetween('order.created_at', [$started_at, $ended_at])->get();
        }

        if ($request->user_id) {
            $this->clerkBreakdownOption = Store::Order('store_id',  $this->userModel->store_id)->get();
            $this->clerkBreakdown = Store::Order('store_id',  $this->userModel->store_id)->whereBetween('order.created_at', [$started_at, $ended_at])->where('user_id', $user_id)->get();
        } else {
            $this->clerkBreakdownOption = Store::Order('store_id',  $this->userModel->store_id)->get();
            $this->clerkBreakdown = Store::Order('store_id',  $this->userModel->store_id)->whereBetween('order.created_at', [$started_at, $ended_at])->get();
        }

        $this->customerTop = Store::Company('store_id',  $this->userModel->store_id)->whereBetween('order.created_at', [$started_at, $ended_at])->get();

        $this->storeList = Store::get();

        $this->accountList = User::Account('store_id',  $this->userModel->store_id)
            ->where('person_type', 0)
            ->get();

        $accountList = $this->accountList;

        $this->expenseList = Expense::User()
            ->whereIn('expense_user_id', $accountList->pluck('user_id'))
            ->get();

        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();

        // PDF Filter Condition
        if ($request->fileName) {

            // If PDF
            if ($request->format === 'pdf') {
                $this->pdfView = view('dashboard.partial.' . $request->fileName, ['data' => $this->Data()])->render();
                $render = \view('dashboard.create', ['data' => $this->Data()])->render();
                $pdf = App::make('dompdf.wrapper');
                $pdf->loadHTML($render)->setPaper('a4', 'portrait')->setWarnings(false)->save('myfile.pdf');
                return $pdf->stream();
            } else {

                // IF CSV

            }
        } else {

            // flushing sessions
            $request->session()->forget('date');
            $request->session()->forget('user');

            // New Session, If user Filter 
            if ($user_id) {

                $request->session()->flash('user', [
                    'started_at' => $started_at,
                    'ended_at' => $ended_at,
                    'user_id' => $user_id,
                ]);
            } else {

                // if period/date range only

                $request->session()->flash('date', [
                    'started_at' => $started_at,
                    'ended_at' => $ended_at,
                ]);
            }

            return view('dashboard.index', ['data' => $this->Data()]);
        }
    }

    public function Create()
    {
    }

    public function Store(Request $request)
    {
    }

    public function show()
    {
    }

    public function Update()
    {
    }

    public function Destroy()
    {
    }

    private function Data()
    {

        return [

            'eat_in_eat_out' => $this->eat_in_eat_out ?? null,
            'userModel' => $this->userModel ?? null,
            'accountList' => $this->accountList ?? null,
            'orderHourly' => $this->orderHourly ?? null,
            'orderList' => $this->orderList ?? null,
            'orderSettingList' => $this->orderSettingList ?? null,
            'orderListASC' => $this->orderListASC ?? null,
            'orderListLimited100' => $this->orderListLimited100 ?? null,
            'storeList' => $this->storeList ?? null,
            'customerTop' => $this->customerTop ?? null,
            'clerkBreakdownOption' => $this->clerkBreakdownOption ?? null,
            'clerkBreakdown' => $this->clerkBreakdown ?? null,
            'expenseList' => $this->expenseList ?? null,
            'settingModel' => $this->settingModel ?? null,
            'pdfView' => $this->pdfView ?? null,
            'csvView' => $this->csvView ?? null
        ];
    }
}
