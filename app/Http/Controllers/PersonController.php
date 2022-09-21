<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



use App\Models\Store;
use App\Models\Person;
use App\Models\User;
use App\Models\Setting;

class PersonController extends Controller
{
    private $personList;
    private $personModel;
    private $userModel;
    private $storeModel;
    private $settingModel;
    

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('sessionMiddleware');
    }

    public function Index(Request $request){

        $this->init();

        $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');

        $a = $request->session()->all();

        if ($request->session()->has('action') && $request->session()->get('action') == 'Customer') {
            //customer
            $this->personList = Person::whereIn('person_user_id', $userList)
            ->where('persontable_type', 'Company')
            ->where('person_type', 2) //see person model type function
            ->paginate(20);

            $request->session()->reflash();
        }else{
            //employees
            $this->personList = Person::whereIn('person_user_id', $userList)
            ->where('persontable_type', 'Store')
            ->paginate(20);
        }
       

        return view('person.index', ['data' => $this->Data()]);        
    }

    public function Create(){
       
        $this->init();
        $this->personModel = new Person();
        
        return view('person.create', ['data' => $this->Data()]); 
    }

    public function Store(Request $request){
        Person::insert($request->except('_token', '_method'));
        return view('person.index', ['data' => $this->Data()]);        
    }

    public function Edit($person){
        $this->personModel = Person::find($person);
        return view('person.edit', ['data' => $this->Data()]);  
    }

    public function Update(Request $request, $person){

       Person::where('person_id', $person)
       ->update($request->except('_token', '_method'));

        return view('person.edit', ['data' => $this->Data()]);  
    }

    public function Destroy($person){
        Person::destroy($person);
        PersonPerson::where('person_person_person_id', $person)
        ->destroy();

        return redirect()->route('person.index');  
    }

    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();
       
    }

    private function Data(){

        return [
           
            'personList' => $this->personList,
            'personModel' => $this->personModel,
            'userModel' => $this->userModel,
            'storeModel' => $this->storeModel,
            'settingModel' => $this->settingModel,
        ];
       
    }
}
