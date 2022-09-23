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
        $this->Init();
        
       
        $request->session()->reflash('view');

        if ($request->session()->get('view') == 'Ins-&-Out') {
            $this->warehouseList =  Warehouse::Store()
            ->orwhere('warehouse_type', 'In')
            ->orwhere('warehouse_type', 'Out')
            ->paginate(20);
        }
        elseif ($request->session()->get('view') != 'Ins-&-Out') {
            $this->warehouseList =  Warehouse::where('warehouse_type', $request->session()->get('view'))->orderby('warehouse_id','desc')->get();
        }
        else {
            $accountList = User::Account('store_id',  $this->userModel->store_id)
            ->where('person_type', 0)
            ->get();

            $this->warehouseList = Warehouse::Store()
            ->whereIn('warehouse_user_id', $accountList->pluck('user_id'))
            ->get();

            
        }

       
         
       return view('warehouse.index', ['data' => $this->Data()]); 
    }

    public function Create(){

        $this->warehouseModel = New warehouse();
        return view('warehouse.create', ['data' => $this->Data()]);  
    }

    public function Store(Request $request){
        Warehouse::insert($request->except('_token', '_method'));

        return redirect()->back()->with('success', 'Transfer added Successfuly');
    }

    public function getWarehouse_status($status = '')
    {
        switch ($status) {
            case 'FIFO':
                return 0;
                break;
            case 'Average Cost Price':
                return 1;
                break;
            default:
                return 0;
                break;
        }
    }
    public function getWarehouse_type($type = '')
    {
        switch ($type) {
            case 'return':
                return 0;
                break;
            case 'delivery':
                return 1;
                break;
            case 'transfer':
                return 2;
                break;
            case 'wastage':
                return 3;
                break;
            default:
                return 0;
                break;
        }
    }
    public function Edit($warehouse){
        $this->warehouseList = Warehouse::where('warehouse_id', $warehouse)->get();
        $this->stockModel = Stock::find($this->warehouseList->first()->warehouse_stock_id);
        $this->stockModel['edit'] = true;
        $this->Init();

        return view('warehouse.edit', ['data' => $this->Data()]);  
    }

    public function Update(Request $request, $warehouse){
      
        $request->session()->reflash();
        //used to remember the route

        if ($request->has('deleteButton')) {
            $this->Destroy($request, $warehouse);
        } else {
            foreach ($request->warehouse as $key => $value) {
                Warehouse::where('warehouse_id', $value['warehouse_id'])->update($value);
            }
        }
        
    
       return redirect()->back()->with('success', 'Transfer Updated Successfuly');
    }

    public function Destroy(Request $request,$warehouse){
        if($request->has('deleteButton')){
            foreach ($request->get('stock_transfer_checkbox') as $key => $value) {
                Warehouse::destroy($value);
            }
        }else{
            Warehouse::destroy($warehouse);
        }

        return redirect()->back()->with('success', 'Transfer Updated Successfuly');
    }

    private function Init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

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
            'warehouseList' => $this->warehouseList,
            'warehouseModel' => $this->warehouseModel
        ];
       
    }
}
