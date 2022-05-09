<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Stock;
use App\Models\Stockroom;
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
    private $stockModel;
    private $categoryList;
    private $settingModel;
    private $fileModel;
    private $companyList;
    private $stockroomList;
   
    
    public function Index(){

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)
        ->paginate(20);

        $this->Init();
        
        return view('stock.index', ['data' => $this->Data()]);        
    }

    public function Create(){
        $this->stockModel = new Stock();
        

        $this->Init();
        
        return view('stock.create',  ['data' => $this->Data()]); 
    }

    public function Store(Request $request){
        
        $this->validate($request, [
           
            'file' => 'required_if:content_file_url,null | max:1024000 |mimes:xls,xlsx,csv',   

        ], [
            'required' => 'This field is required',
            'required_if' => 'This field is required'
        ]);

        if ($request->has('file')) {
            
            $this->ReadFile($request->file('file'));
            
        }
        
        Stock::insert($request->except('_token', '_method'));

        return view('stock.index', ['data' => $this->Data()]);        
    }

    public function Edit($stock){
        $this->stockModel = Stock::find($stock);
        $this->stockroomList = Stockroom::where('stockroom_stock_id', $stock)->get();
        

        $this->Init();

        return view('stock.edit', ['data' => $this->Data()]);  
    }

    public function Update(Request $request, $stock){

        $stockArray = $request->except('_token', '_method', 'stockroom');

       Stock::where('stock_id', $stock)
       ->update($stockArray);

        return view('stock.edit', ['data' => $stock]);  
    }

    public function Destroy($stock){
        Stock::destroy($stock);

        return redirect()->route('stock.index');  
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

    private function ReadFile($file){
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
                $j++;
            }
        }
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
            'stockroomList' => $this->stockroomList
        ];
       
    }
}
