<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Address;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    private $addressModel;
    private $addressList;

    public function Index(){
        $addressList = Address::get();
        return view('address.index', ['addressList' => $addressList]);        
    }

    public function Create(Request $request){
      

        if ($request->has('add_address')) {
           $this->addressModel = new Address();
           $this->addressModel->addresstable_id = $request->get('addresstable_id');
           $this->addressModel->addresstable_type = Account::Category()[$request->get('account_type')];
        }

        return view('address.create', ['data' => $this->Data()]); 
    }

    public function Store(Request $request){
        Address::insert($request->except('_token', '_method'));
        return view('address.index', ['addressList' => $addressList]);  
    }

    public function Edit($address){
        $addressModel = Address::find($address);
        return view('address.edit', ['address' => $addressModel]);  
    }

    public function Update(Request $request, $address){

       Address::find()
       ->update($request->except('_token', '_method'));

        return view('address.edit', ['address' => $address]);  
    }

    public function Destroy($address){
        Address::destroy($address);
        PersonAddress::where('person_address_address_id', $address)
        ->destroy();

        return redirect()->route('address.index');  
    }

    private function Data(){
        return [
            'addressModel' => $this->addressModel,
            'addressList' => $this->addressList,
        ];
    }

}
