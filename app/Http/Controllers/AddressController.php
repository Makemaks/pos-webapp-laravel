<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Address;
use App\Models\Account;
use App\Models\User;
use App\Models\Store;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr; 

class AddressController extends Controller
{
    private $userModel;
    private $stockList;
    private $stockModel;
    private $storeList;
    private $storeModel;
    private $addressModel;
    private $addressList;

    public function Index(Request $request){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->Init();
        
        $request->session()->reflash();

        $this->addressList = Address::get();
        return view('address.index', ['data' => $this->Data()]); 
    }

    public function Create(Request $request){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->Init();
        $this->addressModel = new Address();
        return view('address.create', ['data' => $this->Data()]); 
    }

    public function Store(Request $request){
        $request->session()->reflash();
        if(isset($request['address_geolocation'])){
            $request['address_geolocation'] = json_encode($request['address_geolocation']);
        }
        if(isset($request['address_line'])){
            $request['address_line'] = json_encode($request['address_line']);
        }
        if(isset($request['address_phone'])){
            $request['address_phone'] = json_encode($request['address_phone']);
        }
        Address::insert($request->except('_token', '_method'));
        return view('address.index', ['addressList' => $addressList]);  
    }

    public function Edit($address){
        $this->addressList = Address::where('address_id', $address)->get();
        $this->stockModel = Stock::find($this->addressList->first()->addresstable_id);
        $this->stockModel['edit'] = true;
        $this->Init();

        return view('address.edit', ['data' => $this->Data()]);  
    }

    public function Update(Request $request, $address){
      
        $request->session()->reflash();
        //used to remember the route

        if ($request->has('deleteButton')) {
            $this->Destroy($request, $address);
        } else {
            foreach ($request->address as $key => $value) {
                Address::where('address_id', $value['address_id'])->update($value);
            }
        }
        
    
       return redirect()->back()->with('success', 'Address Updated Successfuly');
    }

    public function Destroy(Request $request,$address){
        $request->session()->reflash();
        if($request->has('deleteButton')){
            foreach ($request->get('address_checkbox') as $key => $value) {
                Address::destroy($value);
            }
        }else{
            Address::destroy($address);
        }

        return redirect()->back()->with('success', 'Address Deleted Successfuly');
    }

    private function Init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->storeList = Store::List('root_store_id', $this->userModel->store_id);
        
        $this->storeModel = Store::Account('store_id', $this->userModel->store_id)
        ->first();
        $this->addressList = Address::get();
    }

    private function Data(){
        return [
            'addressModel' => $this->addressModel,
            'addressList' => $this->addressList,
            'userModel' => $this->userModel,
            'stockList' => $this->stockList,
            'stockModel' => $this->stockModel,
            'storeList' => $this->storeList,
            'storeModel' => $this->storeModel,
        ];
    }

}
