<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\User;
use App\Models\Store;
use App\Models\Setting;
use App\Models\Account;
use App\Models\Company;

class MenuController extends Controller
{
    private $userModel;
    private $stockList;
    private $storeList;
    private $stockModel;
    private $categoryList;
    private $settingModel;
    private $fileModel;
    private $companyList;
    private $warehouseList;

   public function stock(Request $request){

    $request->session()->flash('view', $request->view);
     
     switch ($request->view):
         case 'stock-list':
            return redirect()->route('stock.index');

             break;
         case 'order':
            return redirect()->route('order.index');

             break;
         case (in_array($request->view, Warehouse::WarehouseType())):
             
             $view = array_search( $request->view, Warehouse::WarehouseType());
             $request->session()->flash('view', $view);

             return redirect()->route('warehouse.index');

             break;
         default:
             echo "i is not equal to 0, 1 or 2";
     endswitch;
    
   }

   public function setting(Request $request){
       
        
     
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
    
        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();

        switch ($request->view):
            case (in_array($request->view, Setting::settingGroup())):
            
            $view = array_search( $request->view, Setting::settingGroup());
            $request->session()->flash('view', $view);

            return redirect()->route('setting.index');

                break;
            case 'order':
            return redirect()->route('order.index');

                break;
            case (in_array($request->view, Warehouse::WarehouseType())):
                
                $view = array_search( $request->view, Warehouse::WarehouseType());
                

                return redirect()->route('warehouse.index');

                break;
            default:
                echo "i is not equal to 0, 1 or 2";
        endswitch;
    
   }

   public function sale(){

    
   }

   public function customer(){

    
   }

   private function Init(){
      $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
      ->first();

      

      $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();

      $b = Auth::user()->user_account_id;
      $a = $this->userModel->store_id;
      
      $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();
      $this->settingModel = Setting::find($this->settingModel->setting_id);

      $this->categoryList = $this->settingModel->setting_stock_category;


      $this->storeList = Store::List('root_store_id', $this->userModel->store_id);
      
      $storeModel = Store::Account('store_id', $this->userModel->store_id)
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
            'companyList' => $this->companyList,
            'warehouseList' => $this->warehouseList
        ];
   }


}
