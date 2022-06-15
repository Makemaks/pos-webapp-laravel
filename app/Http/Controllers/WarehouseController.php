<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\User;
use App\Models\Store;
use App\Models\Setting;
use App\Models\Account;
use App\Models\Company;

class WarehouseController extends Controller
{

    private $userModel;
    private $stockList;
    private $storeList;
    private $stockModel;
    private $categoryList;
    private $settingModel;
    private $fileModel;
    private $companyList;
    private $warehouseModel;
    private $warehouseList;
    private $storeModel;
    

   

    public function Index(Request $request){

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

       
        $request->session()->reflash('view');

        if ($request->session()->get('view') == 'Ins-&-Out') {
            $this->warehouseList =  Warehouse::Store()
            ->orwhere('warehouse_type', 'In')
            ->orwhere('warehouse_type', 'Out')
            ->paginate(20);
        }
        elseif ($request->session()->get('view') != 'Ins-&-Out') {
            $this->warehouseList =  Warehouse::where('warehouse_type', $request->session()->get('view'))->paginate(20);
        }
        else {

            $accountList = User::Account('store_id',  $this->userModel->store_id)
            ->where('person_type', 0)
            ->get();

            $this->warehouseList = Warehouse::Store()
            ->whereIn('warehouse_user_id', $accountList->pluck('user_id'))
            ->paginate(20);

            $this->Init();
        }
         
       return view('warehouse.index', ['data' => $this->Data()]); 
    }

    public function Create(){

        $this->warehouseModel = New warehouse();
        return view('warehouse.create', ['data' => $this->Data()]);  
    }

    public function Store(Request $request){


        Warehouse::insert($request->except('_token', '_method'));
        return view('warehouse.index', ['data' => $this->Data()]);
    }

    public function Edit($warehouse){
        $this->warehouseList = Warehouse::where('warehouse_id', $warehouse)->get();
        $this->stockModel = Stock::find($this->warehouseList->first()->warehouse_stock_id);

        $this->Init();

        return view('warehouse.edit', ['data' => $this->Data()]);  
    }

    public function Update(Request $request, $warehouse){

       Warehouse::find($warehouse)
       ->update($request->except('_token', '_method'));

        return view('warehouse.edit', ['data' => $this->Data()]);  
    }

    public function Destroy($warehouse){
        Warehouse::destroy($warehouse);
        PersonWarehouse::where('person_warehouse_warehouse_id', $warehouse)
        ->destroy();

        return redirect()->route('warehouse.index');  
    }

    private function Init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();
        
        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();
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
            'warehouseList' => $this->warehouseList,
            'warehouseModel' => $this->warehouseModel
        ];
       
    }
}
