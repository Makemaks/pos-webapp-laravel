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
use App\Models\Stock;
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
    private $awaitingCartList = [];
    private $authenticatedUser;
    private $accountList;
    private $pdfView;
    private $csvView;



    public function Index(Request $request)
    {

        $datePeriod = Store::DatePeriod($request);

        $this->userModel = $datePeriod['userModel'];

        $this->clerkBreakdownOption = $datePeriod['clerkBreakdownOption'];

        $this->clerkBreakdown = $datePeriod['clerkBreakdown'];

        $this->orderList = $datePeriod['orderList'];

        $this->orderListASC = $datePeriod['orderListASC'];

        $this->orderSettingList = $datePeriod['orderSettingList'];

        $this->orderHourly = $datePeriod['orderHourly'];

        $this->eat_in_eat_out = $datePeriod['eat_in_eat_out'];

        $this->customerTop = Store::Company('store_id',  Auth::user()->store_id)
        ->whereBetween('order.created_at', [$datePeriod['started'], $datePeriod['ended']])
        ->limit(10)
        ->get();
        
        $this->storeList = Store::get();

        $this->accountList = User::Account('store_id',  Auth::user()->store_id)
            ->where('person_type', 0)
            ->get();

        $accountList = $this->accountList;

        $this->expenseList = Expense::User()
            ->whereIn('expense_user_id', $accountList->pluck('user_id'))
            ->get();

        $this->settingModel =  $datePeriod['settingModel'];

        $this->stockList = Stock::List('stock_store_id', Auth::user()->store_id)->get();

        // If its export PDF / CSV
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

                dd($request->all());

            }
        } else {

            // flushing sessions
            $request->session()->forget('date');
            $request->session()->forget('user');

            // New Session, If user Filter 
            if ($datePeriod['user_id']) {

                $request->session()->flash('user', [
                    'started_at' => $datePeriod['started'],
                    'ended_at' => $datePeriod['ended'],
                    'user_id' => $datePeriod['user_id'],
                    'title' => $datePeriod['title'],
                ]);
            } elseif ($request->started_at && $request->ended_at) {

                // if period/date range only
                $request->session()->flash('date', [
                    'started_at' => $datePeriod['started'],
                    'ended_at' => $datePeriod['ended'],
                    'title' => $datePeriod['title'],
                ]);
            } else {
                // No Filters
                $request->session()->flash('title', [
                    'title' => $datePeriod['title'],
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
            'csvView' => $this->csvView ?? null,
            'stockList' => $this->stockList ?? null
        ];
    }
}
