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
    private $authenticatedUser;
   
    
     
    public function Index(Request $request){

       

        $this->authenticatedUser = Auth::user();
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)->first();
       
        $this->orderList = Store::Sale('store_id',  $this->userModel->store_id)->get();

       
                    
        $this->storeList = Store::get();

        //get the system owner account
        $accountList = User::Account('store_id',  $this->userModel->store_id)
        ->where('person_type', 0)
        ->get();

        $this->expenseList = Expense::User()
        ->whereIn('expense_user_id', $accountList->pluck('user_id'))
        ->get();

        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();

     
        return view('dashboard.index', ['data' => $this->Data()]);
    }

    public function Create(){
       
    }

    public function Store(){
       
    }

    public function Edit(){
        return view('dashboard.edit', ['data' => $this->Data()]);
    }

    public function Update(){

    }

    public function Destroy(){

    }

    private function Data(){
        return [
           
            'orderList' => $this->orderList,
          
          
            'storeList' => $this->storeList,
            'expenseList' => $this->expenseList,
            'settingModel' => $this->settingModel
        ];
    }
    
}
