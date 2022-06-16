<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;

use App\Models\Stock;
use App\Models\Store;
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
    
    

    public function __construct()
    {
       
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    
        $this->init();
        $this->user = 0;

        $this->userList = User::Store('person_user_id', $this->userModel->user_id)
        ->orderBy('person_name->person_firstname')
        ->get();

       
        

        
        if ($request->has('id') && $request->has('view')) {
            $request->session()->flash('view', $request['view']);
            $request->session()->flash('id', $request['id']);
            
            $setting_stock_group = $this->settingModel->setting_stock_group[$request['id']];
            $setting_stock_group = collect($this->settingModel->setting_stock_group)->where('type', $setting_stock_group['type']);
            $this->settingModel->setting_stock_group = $setting_stock_group;

            $where = 'stock_merchandise->'.$request['view'].'_id';
            $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)
            ->orWhere($where, $request['id'])
            ->paginate(12);
        } 
        elseif($request->has('id') && $request->has('type')){
            $setting_stock_group = collect($this->settingModel->setting_stock_group)->where('type', $request['id']);
            $this->settingModel->setting_stock_group = $setting_stock_group;
            $request->session()->flash('view', $request['type']);
           
        }
        
       
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
       
        
        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();
       
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
            'userList' => $this->userList
        ];
    }

  
}
