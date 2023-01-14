<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;

use App\Models\User;
use App\Models\Person;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Warehouse;
use App\Models\Setting;
use App\Models\Receipt;

class HomeController extends Controller
{
    private $userModel;
    private $personModel;
    private $routeList;
    private $stockList;
    private $authenticatedUser;
    private $categoryList;
    private $userList;

    
    private $storeModel;
    private $settingModel;
    private $settingList;
    private $paymentModel;
    private $sessionCartList = [];
    private $schemeList;
    private $personList;
    private $setupList;
    

    public function __construct()
    {
        $this->middleware('auth');
    }

    //for session see session middleware
    public function index(Request $request)
    {

        $this->init();
         //setup new
       
        $this->setupList = Receipt::SessionInitialize($request);
        
        $this->userList = User::Store('person_user_id', $this->userModel->user_id)
        ->orderBy('person_name->person_firstname')
        ->get();

        $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');

        $this->personList = Person::whereIn('person_user_id', $userList)
        ->orderBy('person_name->person_firstname', 'asc')
        ->get();

        $this->settingModel->setting_stock_set = collect($this->settingModel->setting_stock_set)->where('type', 0);
        $settingModel = new Setting();
      
        $this->settingModel->setting_key = $settingModel->setting_key;

        $this->stockList = Stock::Warehouse('warehouse_store_id', $this->userModel->store_id)
        ->groupBy('stock_id')
        //->where('warehouse_stock_quantity', '>', 0)
        ->paginate(24);

       
       
        $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');

        $this->personList = Person::Address('person_organisation_id', $this->userModel->organisation_id)
        ->paginate(20);

 
 
      
        return view('home.index', ['data' => $this->Data()]);
    }

    public function create(){
       
    }

    public function store(){
        return redirect('home.index');
    }
    
    private function init(){
        $a = Auth::user()->user_account_id;
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->storeModel = Store::find($this->userModel->store_id);
        $this->settingModel = Setting::where('settingtable_id',  $this->userModel->store_id)->first();
        $this->settingList = Setting::where('settingtable_id', $this->userModel->store_id);
    }

    private function Session(Request $request){
        
       
    }
    
    private function Data(){

        return [
            'authenticatedUser' => $this->authenticatedUser,
            'stockList' => $this->stockList,
            'userModel' => $this->userModel,
            'storeModel' => $this->storeModel,
            'personModel' => $this->personModel,
            'cartList' => $this->sessionCartList,
            'schemeList' => $this->schemeList,
            'settingModel' => $this->settingModel,
            'settingList' => $this->settingList,
            'userList' => $this->userList,
            'personModel' => $this->personModel,
            'personList' => $this->personList,
            'setupList' => $this->setupList
            
           
        ];
    }

  
}
