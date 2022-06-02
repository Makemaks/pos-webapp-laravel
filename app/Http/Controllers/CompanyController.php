<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Company;

class CompanyController extends Controller
{

    private $companyModel;
    private $companyList;
    private  $userModel;
    private  $orderList;

    public function Index(){

        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)->first();
        $this->orderList = Store::Sale('store_id',  $this->userModel->store_id)->get();

      if ($request->session()->get('view') == 'supplier') {
            $this->companyList = Company::List()
            ->where('store_id',  $this->userModel->store_id)
            ->where('company_type', 0)
            ->paginate(20);
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

        $requestinput = $request->except('_token', '_method');
        $requestInput['project_account_id'] = Auth::user()->user_account_id;

        Company::insert($requestInput);
        return redirect()->route('company.index')->with('success', 'Company Successfully Added');
    }

    public function Edit($company){
        $this->companyModel = Company::find($company);
        return view('company.edit', ['data' => $this->Data()]);
    }

    public function Update(Request $request, $company){

      Company::find($company)
       ->update($request->except('_token', '_method'));

        return view('company.edit', ['company' => $company]);
    }

    public function Destroy($company){
        Company::destroy($company);
        $contactList = Contact::where('contact_company_id', $company)->get();

        $personList = $contactList
        ->where('contact_contactable_type', 'person')
        ->pluck('contact_contactable_id');

        $addressList = $contactList
        ->where('contact_contactable_type', 'address')
        ->pluck('contact_contactable_id');

        Person::whereIn('contact_contactable_id', $personList)->destroy();
        Address::whereIn('contact_contactable_id', $addressList)->destroy();

        Contact::whereIn('contact_company_id', $company)
        ->destroy();


        return redirect()->route('company.index')->with('success', '');
    }

    private function Data(){
        return [
            'companyModel' => $this->companyModel,
            'companyList' => $this->companyList
        ];
    }


}
