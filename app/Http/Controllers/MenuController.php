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
use Carbon\Carbon;
use Illuminate\Support\Arr;

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
    $request->session()->flash('action', $request->route()->getActionMethod());

     switch ($request->view):
         case 'stock-list':
            return redirect()->route('stock.index');

             break;
         case 'order':
            return redirect()->route('order.index');

             break;
         case (in_array($request->view, Warehouse::WarehouseType())):
             
             $type = array_search( $request->view, Warehouse::WarehouseType());
             $request->session()->flash('type', $type);

             return redirect()->route('warehouse.index');

             break;
         
         case 'ins-&-out':


             return redirect()->route('warehouse.index');

             break;

        case 'supplier':
            return redirect()->route('company.index');

            break;

        case 'case-size':

            $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();
                    
            $this->settingModel = Setting::where('setting_account_id', $this->userModel->store_id)->first();
            return view('menu.setting.settingCaseSize', ['data' => $this->Data()]);

            // return redirect()->route('setting.index');

            break;

        case 'recipe':

            $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();
                    
            $this->settingModel = Setting::where('setting_account_id', $this->userModel->store_id)->first();
            return view('menu.setting.settingRecipe', ['data' => $this->Data()]);
            

            return redirect()->route('setting.index');

            break;

        case 'stock-variance':

            $this->settingModel = Setting::where('setting_account_id', $this->userModel->store_id)->first();
            

            return redirect()->route('setting.index');

            break;
       
         default:
             echo "i is not equal to 0, 1 or 2";
     endswitch;
    
   }

   public function setting(Request $request){
    $request->session()->flash('view', $request->view);
    $request->session()->flash('action', $request->route()->getActionMethod());
        $this->Init();
        // dd($this->userModel->store_id);
        $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)
            ->paginate(20);

        // dd($request->view);
        if ($this->settingModel == null) {
            $this->settingModel = new Setting();
        }

        switch ($request->view):
            case (in_array($request->view, Setting::SettingStockSet())):
            
                $type = array_search( $request->view, Setting::SettingStockSet());
                $request->session()->flash('type', $type);
                $request->session()->flash('view', $request->view);

                return view('menu.setting.SettingStockSet', ['data' => $this->Data()]);

                break;
          
           
            case 'mix-&-match':
                return view('menu.setting.mix-&-match', ['data' => $this->Data()]);

                break;
            
            case 'finalise-key':
                $group = array_search( $request->view, Setting::SettingKeyGroup());
                $request->session()->flash('group', $group);
                return view('menu.setting.settingKey', ['data' => $this->Data()]);
                break;

            case 'status-key':
                $group = array_search( $request->view, Setting::SettingKeyGroup());
                $request->session()->flash('group', $group);
                return view('menu.setting.settingKey', ['data' => $this->Data()]);
                break;

            case 'transaction-key':
                $group = array_search( $request->view, Setting::SettingKeyGroup());
                $request->session()->flash('group', $group);
                return view('menu.setting.settingKey', ['data' => $this->Data()]);
                break;

            case 'receipt':

                return view('menu.setting.receipt', ['data' => $this->Data()]);

                break;

            case 'tag':

                return view('menu.setting.settingStockTag', ['data' => $this->Data()]);

                break;
            

            case 'tag-group':

                return view('menu.setting.settingStockTagGroup', ['data' => $this->Data()]);

                break;

            case 'voucher':
                
                return view('menu.setting.receipt', ['data' => $this->Data()]);

                break;

            case 'reasons':
                
                return view('menu.setting.receipt', ['data' => $this->Data()]);

                break;

            case 'tax':
                
                return view('menu.setting.settingVat', ['data' => $this->Data()]);

                    break;

            case 'set-menu':
                
                return view('menu.setting.settingStockSetMenu', ['data' => $this->Data()]);

                    break;

            case 'preset-message':

                return view('menu.setting.settingPresetMessage', ['data' => $this->Data()]);

                    break;

            case 'price-level-scheduler':
                
                $StockPrices = $this->stockList->first()->stock_price;

                $stock_price_count = 0;
                $stock_price_key = 0;
                foreach($StockPrices as $key => $StockPrice) {
                    if($stock_price_count < count($StockPrice)) {
                        $stock_price_key = $key;
                        $stock_price_count = count($StockPrice);
                    }
                }
                
                $this->settingModel['stock_prices'] = collect($StockPrices[$stock_price_key])->keys();

                return view('menu.setting.settingPriceLevelScheduler', ['data' => $this->Data()]);

                    break;

            case 'reasons':
                
                return view('menu.setting.receipt', ['data' => $this->Data()]);

                break;


            case 'floor-plan':
                $request->session()->flash($request->view, 'view');
                $this->settingModel = Setting::get();
                return view('menu.setting.floor-plan', ['data' => $this->Data()]);

                    break;

            case (in_array($request->view, Warehouse::WarehouseType())):
                
                $view = array_search( $request->view, Warehouse::WarehouseType());
                return redirect()->route('warehouse.index');

                break;

            default:
                echo "i is not equal to 0, 1 or 2";
        endswitch;
    
   }

   public function order(Request $request){

    $request->session()->flash('view', $request->view);
    $request->session()->flash('action', $request->route()->getActionMethod());
    
    switch ($request->view):
        case 'sale':
            return redirect()->route('order.index');
            break;

        case 'till':
            return redirect()->route('order.index');
            break;

        case 'bill':
            return redirect()->route('order.index');
            break;

        default:
            echo "i is not equal to 0, 1 or 2";
    endswitch;
    
   }

   public function home(Request $request){

    $request->session()->flash('view', $request->view);
    $request->session()->flash('action', $request->route()->getActionMethod());
    
    switch ($request->view):
        case 'category':
            return redirect()->route('order.index');
            break;

        case 'group':
            return redirect()->route('order.index');
            break;

        case 'list-plu':
            return redirect()->route('order.index');
            break;

        case 'mix-&-match':
            return redirect()->route('order.index');
            break;

        default:
            echo "i is not equal to 0, 1 or 2";
    endswitch;
    
   }

   public function customer(Request $request){

        $request->session()->flash('view', $request->view);
        $request->session()->flash('action', $request->route()->getActionMethod());
        
        switch ($request->view):
            case 'person':
                return redirect()->route('person.index');
                break;

            case 'company':
                return redirect()->route('company.index');
                break;

            default:
                echo "i is not equal to 0, 1 or 2";
        endswitch;

   }

   private function Init(){
      $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
      ->first();

      $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();

      $this->settingModel = Setting::where('setting_account_id', $this->userModel->store_id)->first();
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
            'warehouseList' => $this->warehouseList,
        ];
   }


}
