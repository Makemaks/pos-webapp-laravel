<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;

use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\User;
use App\Models\Store;
use App\Models\Setting;
use App\Models\Account;
use App\Models\Company;


class StockController extends Controller
{
    private $userModel;
    private $stockList;
    private $storeList;
    private $storeModel;
    private $stockModel;
    private $categoryList;
    private $settingModel;
    private $fileModel;
    private $companyList;
    private $warehouseList;
   
    
    public function Index(Request $request){

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

        $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)
            ->paginate(20);

        $this->Init();
        
        return view('stock.index', ['data' => $this->Data()]);  
              
    }

    public function Create()
    {
        $this->stockModel = new Stock();
        $this->Init();

        //setup
        $stock_nutrition = $this->stockModel->stock_nutrition;
        foreach ($this->settingModel->setting_stock_nutrition as $key => $value) {
            $temp_stock_nutrition[$key] = $stock_nutrition;
        }
        
        $this->stockModel->stock_nutrition = $temp_stock_nutrition;
      

        return view('stock.create',  ['data' => $this->Data()]);
    }

    public function Store(Request $request){
        
        $this->Init();

      /*   $this->validate($request, [
           
            'file' => 'required_if:content_file_url,null | max:1024000 |mimes:xls,xlsx,csv',   

        ], [
            'required' => 'This field is required',
            'required_if' => 'This field is required'
        ]); */

        if ($request->has('file')) {
            $this->ReadFile($request->file('file'));
        }

        //$this->stockModel = new Stock();
        $input = $request->except('_token', '_method', 'warehouse', 'form');
        $input += Arr::collapse( $request->only('form') );
        
        $this->Operation($input);
        $this->stockModel += ['stock_store_id' => $this->userModel->store_id];
       
       
       

        Stock::insert($this->stockModel );
        Warehouse::insert($request->only('warehouse')['warehouse']);

       

        return view('stock.index', ['data' => $this->Data()]);
    }

    public function Edit($stock)
    {
        $this->stockModel = Stock::find($stock);

        

        $this->warehouseList = Warehouse::where('warehouse_stock_id', $stock)->get();
        

        $this->Init();

        return view('stock.edit', ['data' => $this->Data()]);
    }

    public function Update(Request $request, $stock)
    {

        $input = $request->except('_token', '_method', 'warehouse');
 
        $this->stockModel = Stock::find($stock)->toArray();
 
       
 
        foreach ((array)$request['stock_supplier'] as $keystock_supplier => $stock_supplier) {
             foreach ($stock_supplier as $key => $value) {
                 $stockModel['stock_supplier'][$keystock_supplier][$key]  = $value;
             }
        }
 
        foreach ((array)$request['stock_price'] as $keystock_price  => $stock_price) {
             foreach ($stock_price as $key => $value) {
                 $stockModel['stock_price'][$keystock_price][$key]  = $value;
             }
         }

         foreach ((array)$request['stock_price_quantity'] as $keystock_price_quantity  => $stock_price_quantity) {
            $stockModel['stock_price_quantity'][$keystock_price_quantity] =  $stock_price_quantity;
        }
 
        $this->stockModel = $this->stockModel->except(['created_at']);
        Stock::where('stock_id', $stock)->update($this->stockModel->toArray());

        foreach ($request->only('warehouse')['warehouse'] as $key => $value) {
            Warehouse::where('warehouse_id',  $value['warehouse_id'])->update($value);
        }

        return redirect()->route('stock.edit', $stock);
 
     }

   

    public function Destroy($stock)
    {
        Stock::destroy($stock);
        Warehouse::where('warehouse_user_id',$stock)->delete();
        return redirect()->route('stock.index');
    }

    private function Init()
    {
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

    private function ReadFile($file)
    {
        if ($file) {

            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes//Check for file extension and size



            // Reading file
            $file = fopen($file, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;

            //Read the contents of the uploaded file 
            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata);
                // Skip first row (Remove below comment if you want to skip the first row)
                if ($i == 0) {
                    $i++;
                    continue;
                }

                for ($c = 0; $c < $num; $c++) {
                    $importData_arr[$i][] = $filedata[$c];
                }
                $i++;
            }
            fclose($file); //Close after reading$j = 0;

            foreach ($importData_arr as $importData) {
                $name = $importData[1]; //Get user names
                $email = $importData[3]; //Get the user emails
                // $j++;
            }
        }
    }

    private function Operation($request){

        foreach ((array)$request['stock_supplier']['supplier_id'] as $key_supplier_id => $value_supplier_id) {
            foreach ((array)$request['stock_supplier'] as $keystock_supplier => $stock_supplier) {
                $this->stockModel['stock_supplier'][$keystock_supplier][ $key_supplier_id]  = $stock_supplier[$key_supplier_id];
            }
        }
        

       foreach ((array)$request['stock_cost'] as $keystock_cost  => $stock_cost) {
            foreach ($stock_cost as $key => $value) {
                $this->stockModel['stock_cost'][$keystock_cost][$key]  = $value;
            }
        }

        foreach ((array)$request['stock_cost_quantity'] as $keystock_cost_quantity  => $stock_cost_quantity) {
           $this->stockModel['stock_cost_quantity'][$keystock_cost_quantity] =  $stock_cost_quantity;
       }

       foreach ((array)$request['stock_merchandise'] as $keystock_merchandise  => $stock_merchandise) {
            $this->stockModel['stock_merchandise'][$keystock_merchandise]  = $stock_merchandise;
       }

       foreach ((array)$request['stock_gross_profit'] as $keygross_profit  => $gross_profit) {
            $this->stockModel['stock_gross_profit'][$keygross_profit]  = $gross_profit;
       }

       if ($request['stock_allergen']) {
            foreach ((array)$request['stock_allergen'] as $keystock_allergen  => $stock_allergen) {
                $this->stockModel['stock_allergen'][$keystock_allergen]  = $stock_allergen;
            }
       }

       if ($request['stock_nutrition']) {
            foreach ((array)$request['stock_nutrition'] as $keystock_nutrition  => $stock_nutrition) {
                foreach ($stock_nutrition as $key => $value) {
                    $this->stockModel['stock_nutrition'][$keystock_nutrition][$key]  = $value;
                }
            }
       }

       foreach ((array)$request['stock_web'] as $keystock_web  => $stock_web) {
            foreach ($stock_web as $key => $value) {
                $this->stockModel['stock_web'][$keystock_web][$key]  = $value;
            }
       }

       foreach ((array)$request['stock_terminal_flag'] as $keystock_terminal_flag  => $stock_terminal_flag) {
            foreach ($stock_terminal_flag as $key => $value) {
                $this->stockModel['stock_terminal_flag'][$keystock_terminal_flag][$key]  = $value;
            }
        }

        $this->stockModel = collect($this->stockModel);
    }

    private function Data()
    {

        return [

            'userModel' => $this->userModel,
            'categoryList' => $this->categoryList,
            'stockList' => $this->stockList,
            'stockModel' => $this->stockModel,
            'storeModel' => $this->storeModel,
            'settingModel' =>  $this->settingModel,
            'fileModel' => $this->fileModel,
            'storeList' => $this->storeList,
            'companyList' => $this->companyList,
            'warehouseList' => $this->warehouseList
        ];
    }
}
