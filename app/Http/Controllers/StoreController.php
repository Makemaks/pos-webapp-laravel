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

class StoreController extends Controller
{

    private $userModel;
    private $stockList;
    private $storeList;
    private $stockModel;
    private $categoryList;
    private $settingModel;
    private $fileModel;
    private $companyList;
    private $accountList;
    private $storeModel;

    public function Index(Request $request){

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->Init();
        
       
        $request->session()->reflash();

        $this->storeList = Store::get();
       return view('store.index', ['data' => $this->Data()]); 
    }

    public function Create(){
       
        $this->storeModel = New Store();
        return view('store.create', ['data' => $this->Data()]);  
    }

    public function Store(Request $request){
        $request->session()->reflash();
        $imageName = '';
        if($request->hasFile('store_img')){
            $imageName = time().'.'.$request->store_img->getClientOriginalName();
            $request->store_img->move(public_path('images/uploads/store_images'), $imageName);
        }
        $request['store_image'] = $imageName;
        $request['store_datetime'] = json_encode($request['store_datetime']);
        Store::insert($request->except('_token', '_method','store_img'));
        return redirect()->back()->with('success', 'Store added Successfuly');
    }

    public function Edit($store){
        $this->storeList = Store::where('store_id', $store)->get();
        $this->stockModel = Stock::find($this->storeList->first()->store_stock_id);
        $this->stockModel['edit'] = true;
        $this->Init();

        return view('store.edit', ['data' => $this->Data()]);  
    }

    public function Update(Request $request, $store){
      
        $request->session()->reflash();
        //used to remember the route

        if ($request->has('deleteButton')) {
            $this->Destroy($request, $store);
        } else {
            foreach ($request->store as $key => $value) {
                $value['store_datetime'] = [
                    'started_at' => $value['started_at'],
                    'ended_at' => $value['ended_at']
                ];
                $value['store_datetime'] = json_encode($value['store_datetime']);
                $input = Arr::except($value,['started_at','ended_at']);
                
                Store::where('store_id', $value['store_id'])->update($input);
            }
        }
        
    
       return redirect()->back()->with('success', 'Store Updated Successfuly');
    }

    public function Destroy(Request $request,$store){
        $request->session()->reflash();
        if($request->has('deleteButton')){
            foreach ($request->get('store_checkbox') as $key => $value) {
                Store::destroy($value);
            }
        }else{
            Store::destroy($store);
        }

        return redirect()->back()->with('success', 'Store Deleted Successfuly');
    }

    private function Init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->accountList = User::Account('store_id',  $this->userModel->store_id)
        ->where('person_type', 0)
        ->get();
        $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();
        
        $this->settingModel = Setting::where('setting_account_id', $this->userModel->store_id)->first();
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
        ];
       
    }
}
