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
   
    
     
    public function Index(Request $request){

        $this->authenticatedUser = Auth::user();

        /* 
            Auth::user()->subscribed('default');  //Check if user is subscribed
            Auth::user()->subscription('main')->onGracePeriod(); //cancelled but current subscription has not ende
            Auth::user()->onPlan('bronze'); //check which plan.
            Auth::user()->subscription('default')->cancelled(); //user earlier had a sibscription but cancelled (and no longer on grace period)
        */

        /* if ($request->session()->has('user-session-'.Auth::user()->user_id) == null) {
            $userSession = [
                'authenticatedUser' => $this->authenticatedUser,
                'categoryList' => $this->categoryList,
                'storeModel' =>  $this->storeModel,
                'settingModel' => $this->settingModel,
                'paymentModel' => $this->paymentModel,
                'cartList' => $this->cartItem,
                'cartAwaitingList' => $this->cartItem
            ];
          
            $request->session()->put('user-session-'.Auth::user()->user_id, $userSession);
        } */


        $todayDate = DateTimeHelper::Today();
        $currentWeekSalePercentage = 0;
     
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)->first();
        
        $receipt = Receipt::get();

        $this->orderTodayList =   Store::Order('store_id',  $this->userModel->store_id)
        ->select('order.*', 'person_name', 
        DB::raw('SUM(receipt_stock_cost_id) as order_total_cost'))
        ->groupBy('order_id')
        ->orderBy('order.created_at', 'desc')
        ->whereDate('order.created_at', $todayDate)
        ->paginate(5);

        $this->orderList =   Store::Sale('store_id',  $this->userModel->store_id)
        ->get();

       

        $startOfCurrentWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfCurrentWeek = Carbon::now()->endOfWeek()->format('Y-m-d');
      

        $this->currentWeekSale = Store::Order('store_id', $this->userModel->store_id)
        ->orderBy('order.created_at', 'desc')
        ->whereBetween( 'order.created_at', [$startOfCurrentWeek, $endOfCurrentWeek] )
                        ->pluck('receipt_stock_cost_id')
                        ->sum();
        
        $this->personelStats = Store::Order('store_id', $this->userModel->store_id)
        ->whereYear('order.created_at', '=', Carbon::now()->year)
        ->groupBy('user_id')
        //->orderBy('order.created_at', 'desc')
        ->get();
                    
        $this->storeList = Store::get();

       //get the system owner account
       $accountList = User::Account('store_id',  $this->userModel->store_id)->get();

        $this->expenseList = Expense::User()
        ->whereIn('expense_user_id', $accountList->pluck('user_id'))
        ->get();

        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();

        $a = Auth::user()->user_account_id;
        
        return view('dashboard.index', ['data' => $this->Data()]);
    }

    public function Create(){
        $orderList = Store::where('order_user_id', Auth::user()->user_id);
        return view('dashboard.index', ['orderList' => $orderList]);
    }

    public function Store(){

    }

    public function Edit(){

    }

    public function Update(){

    }

    public function Destroy(){

    }

    private function Data(){
        return [
            'orderTodayList' => $this->orderTodayList,
            'orderList' => $this->orderList,
            'currentWeekSale' => $this->currentWeekSale,
            'personelStats' => $this->personelStats,
            'storeList' => $this->storeList,
            'orderList' => $this->orderList,
            'expenseList' => $this->expenseList,
            'settingModel' => $this->settingModel
        ];
    }
    
}
