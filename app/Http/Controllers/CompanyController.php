<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\User;
use App\Models\Store;
use App\Models\Setting;

class CompanyController extends Controller
{

    private $companyModel;
    private $companyList;
    private $companyType;
    private $storeList;
    private  $userModel;
    private  $orderList;

    public function Index(Request $request){

        // $this->init();
       

    //   if ($request->session()->get('view') == 'supplier') {
    //         $this->companyList = Company::List()
    //         ->where('store_id',  $this->userModel->store_id)
    //         ->where('company_type', 0)
    //         ->paginate(20);
    //   } else {
    //         $this->companyList = Company::Address()
    //         ->where('store_id',  $this->userModel->store_id)
    //         ->where('address_type', 0)
    //         ->paginate(20);
    //   }
        
        $this->companyList = Company::Store()->paginate(10);
        return view('company.index', ['data' => $this->Data()]);
    }

    public function Create(){
        $this->Init();
        $this->companyModel = new Company();
        return view('company.create', ['data' => $this->Data()]);
    }

    public function Store(Request $request){
        $request['company_contact'] = json_encode($request->company_contact);
        $request['company_opening_hour'] = json_encode($request->company_opening_hour);
        Company::insert($request->except('_token', '_method'));
        return redirect()->route('company.index')->with('success', 'Company Successfully Added');
    }

    public function Edit($company){
        $this->Init();
        $this->companyModel = Company::find($company);
        return view('company.edit', ['data' => $this->Data()]);
    }

    public function Update(Request $request, $company){
        Company::where('company_id',$company)->update($request->except('_token', '_method'));
        return redirect()->route('company.index')->with('success', 'Company Successfully Updated');
    }

    public function Destroy($company){
        Company::destroy($company);
        // $contactList = Contact::where('contact_company_id', $company)->get();

        // $personList = $contactList
        // ->where('contact_contactable_type', 'person')
        // ->pluck('contact_contactable_id');

        // $addressList = $contactList
        // ->where('contact_contactable_type', 'address')
        // ->pluck('contact_contactable_id');

        // Person::whereIn('contact_contactable_id', $personList)->destroy();
        // Address::whereIn('contact_contactable_id', $addressList)->destroy();

        // Contact::whereIn('contact_company_id', $company)
        // ->destroy();

        return redirect()->route('company.index')->with('success', '');
    }

    private function Init(){
        // $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        // ->first();
  
        // $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();
  
        // $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();
        // $this->settingModel = Setting::find($this->settingModel->setting_id);
  
        // $this->categoryList = $this->settingModel->setting_stock_category;
  
  
        // $this->storeList = Store::List('root_store_id', $this->userModel->store_id);
        
        // $storeModel = Store::Account('store_id', $this->userModel->store_id)
        // ->first();
  
        //$this->storeList->prepend($storeModel);

        $this->companyList = Company::all();
        $this->companyType = Company::CompanyType();
        $this->storeList = Store::all();
     }

    private function Data(){
        return [
            'companyModel' => $this->companyModel,
            'companyList' => $this->companyList,
            'companyType' => $this->companyType,
            'storeList' => $this->storeList
        ];
    }

    


}
