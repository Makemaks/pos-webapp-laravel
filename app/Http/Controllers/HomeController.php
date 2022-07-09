<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Session;

use App\Models\User;
use App\Models\Person;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\Setting;


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
    private $paymentModel;
    private $sessionCartList = [];
    private $schemeList;
    private $personList;
    private $request;
    

    public function __construct()
    {
        $this->middleware('sessionMiddleware');
        $this->middleware('auth');
    }

    //for session see session middleware
    public function index(Request $request)
    {
        $this->init();
        $this->request = $request;

         //setup new
         if ( $request->session()->has('user-session-'.Auth::user()->user_id.'.'.'setupList') == false) {
            $setupList = [
                "cash" => [],
                "credit" => [],
                "voucher" => [],
                "delivery" => [],
                "discount" => [],
                "customer" => []
            ];

            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'setupList', $setupList);
           
        }

        $setupList =  $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList');
        
        $this->user = 0;

        $this->userList = User::Store('person_user_id', $this->userModel->user_id)
        ->orderBy('person_name->person_firstname')
        ->get();

        $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');

        $this->personList = Person::whereIn('person_user_id', $userList)
        ->orderBy('person_name->person_firstname', 'asc')
        ->get();

        $this->settingModel->setting_stock_group = collect($this->settingModel->setting_stock_group)->where('type', 0);

      /*   $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)
        ->paginate(12); */
       
        $a = $this->Data();
       
      
        return view('home.index', ['data' => $this->Data()]);
    }

    public function create(){
       
    }

    public function store(){
        return redirect('home.index');
    }
    
    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();

       
    }

    private function Session(Request $request){
        
       
    }
    
    private function Data(){

        return [
            'authenticatedUser' => $this->authenticatedUser,
            'stockList' => $this->stockList,
            'userModel' => $this->userModel,
            'personModel' => $this->personModel,
            'sessionCartList' => $this->sessionCartList,
            'schemeList' => $this->schemeList,
            'settingModel' => $this->settingModel,
            'userList' => $this->userList,
            'personModel' => $this->personModel,
            'personList' => $this->personList,
            'request' => $this->request
           
        ];
    }

  
}
