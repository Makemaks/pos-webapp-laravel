<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Stock;
use App\Models\User;
use App\Models\Store;
use App\Models\Setting;
use App\Models\Account;
use App\Models\Company;
use Illuminate\Support\Arr; 

class AccountController extends Controller
{

    private $userModel;
    private $stockList;
    private $stockModel;
    private $storeList;
    private $storeModel;
    private $categoryList;
    private $settingModel;
    private $fileModel;
    private $companyList;
    private $accountList;
    private $accountModel;

    public function Index(Request $request){

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->Init();
        
       
        $request->session()->reflash();

        $this->accountList = Account::get();
       return view('account.index', ['data' => $this->Data()]); 
    }

    public function Create(){
       
        $this->accountModel = New Account();
        return view('account.create', ['data' => $this->Data()]);  
    }

    public function Store(Request $request){
        $request->session()->reflash();
        $request['account_blacklist'] = json_encode($request['account_blacklist']);
        Account::insert($request->except('_token', '_method'));
        return redirect()->back()->with('success', 'Account added Successfuly');
    }

    public function Edit($account){
        $this->accountList = Account::where('account_id', $account)->get();
        $this->stockModel = Stock::find($this->accountList->first()->store_stock_id);
        $this->stockModel['edit'] = true;
        $this->Init();

        return view('account.edit', ['data' => $this->Data()]);  
    }

    public function Update(Request $request, $account){
      
        $request->session()->reflash();
        //used to remember the route

        if ($request->has('deleteButton')) {
            $this->Destroy($request, $account);
        } else {
            foreach ($request->account as $key => $value) {
                Account::where('account_id', $value['account_id'])->update($value);
            }
        }
        
    
       return redirect()->back()->with('success', 'Account Updated Successfuly');
    }

    public function Destroy(Request $request,$account){
        $request->session()->reflash();
        if($request->has('deleteButton')){
            if($request->get('account_checkbox'))
            {
                foreach ($request->get('account_checkbox') as $key => $value) {
                    Account::destroy($value);
                }
            }
        }else{
            Account::destroy($account);
        }

        return redirect()->back()->with('success', 'Account Deleted Successfuly');
    }

    private function Init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->accountList = User::Account('store_id',  $this->userModel->store_id)
        ->where('person_type', 0)
        ->get();
        $this->accountModel = Account::List('account_id', $this->userModel->store_id)->first();
        $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();
        
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();
        $this->settingModel = Setting::find($this->settingModel->setting_id);

        $this->categoryList = $this->settingModel->setting_stock_category;


        $this->storeList = Store::List('root_store_id', $this->userModel->store_id);
        
        $this->storeModel = Store::Account('store_id', $this->userModel->store_id)
        ->first();
        //$this->storeList->prepend($storeModel);
    }
  

     private function Data(){

        return [
           
            'userModel'=> $this->userModel,
            'categoryList' => $this->categoryList,
            'stockList' => $this->stockList,
            'stockModel' => $this->stockModel,
            'settingModel' =>  $this->settingModel,
            'fileModel' => $this->fileModel,
            'storeList' => $this->storeList,
            'storeModel' => $this->storeModel,
            'companyList' => $this->companyList,
            'accountList' => $this->accountList,
            'accountModel' => $this->accountModel,
        ];
       
    }
}
