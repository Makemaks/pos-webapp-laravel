<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\User;
use App\Models\Store;
use App\Models\Stock;
use App\Models\Setting;
use Illuminate\Support\Arr; 

class CompanyController extends Controller
{

    private $userModel;
    private $stockList;
    private $stockModel;
    private $storeList;
    private $storeModel;
    private $categoryList;
    private $settingModel;
    private $companyModel;
    private $companyList;
    private  $orderList;

    public function Index(Request $request){

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->Init();
        $request->session()->reflash();
        if ($request->session()->get('view') == 'supplier') {
            $this->companyList = Company::where('company_type', 0)
            ->get();
        } else {
            $this->companyList = Company::Address()
            ->where('store_id',  $this->userModel->store_id)
            ->where('address_type', 0)
            ->paginate(20);
        }
        return view('company.index', ['data' => $this->Data()]);
    }

    public function Create(){
        $this->companyModel = new Company();
        return view('company.create', ['data' => $this->Data()]);
    }

    public function Store(Request $request){
        $request->session()->reflash();
        $request['company_opening_hour'] = json_encode($request['company_opening_hour']);
        Company::insert($request->except('_token', '_method'));
        return redirect()->route('company.index')->with('success', 'Company Successfully Added');
    }

    public function Edit($company){
        $this->companyList = Company::where('company_id', $company)->get();
        $this->stockModel = Stock::find($this->companyList->first()->company_stock_id);
        $this->stockModel['edit'] = true;
        $this->Init();

        return view('company.edit', ['data' => $this->Data()]); 
    }

    public function Update(Request $request, $company){
        $request->session()->reflash();
        if ($request->has('deleteButton')) {
            $this->Destroy($request, $company);
        } else {
            foreach ($request->company as $key => $value) {
                $value['company_opening_hour'] = [
                    'start_from' => $value['start_from'],
                    'end_to' => $value['end_to']
                ];
                $value['company_opening_hour'] = json_encode($value['company_opening_hour']);
                $input = Arr::except($value,['start_from','end_to']);
                
                Company::where('company_id', $value['company_id'])->update($input);
            }
        }
        return redirect()->back()->with('success', 'Supplier Updated Successfuly');
    }

    public function Destroy(Request $request, $company){
        $request->session()->reflash();
        if($request->has('deleteButton')){
            foreach ($request->get('company_checkbox') as $key => $value) {
                Company::destroy($value);
            }
        }else{
            Company::destroy($company);
        }

        return redirect()->back()->with('success', 'Supplier Updated Successfuly');
    }

    private function Init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
  
        $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();
  
        $this->settingModel = Setting::where('setting_account_id', $this->userModel->store_id)->first();
        $this->settingModel = Setting::find($this->settingModel->setting_id);
  
        $this->categoryList = $this->settingModel->setting_stock_category;
  
  
        $this->storeList = Store::List('root_store_id', $this->userModel->store_id);
        
        $this->storeModel = Store::Account('store_id', $this->userModel->store_id)
        ->first();
        // $this->storeList->prepend($storeModel);
     }

    private function Data(){
        return [
            'userModel'=> $this->userModel,
            'categoryList' => $this->categoryList,
            'stockList' => $this->stockList,
            'stockModel' => $this->stockModel,
            'settingModel' =>  $this->settingModel,
            'storeList' => $this->storeList,
            'storeModel' => $this->storeModel,
            'companyModel' => $this->companyModel,
            'companyList' => $this->companyList,
        ];
    }

    


}
