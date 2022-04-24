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
    private $stockList = [];
    private $authenticatedUser;
    private $categoryList;


    
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
       
        return redirect()->route('dashboard.index');
       
       /*  $this->init();
        $this->user = 0;

        return view('home.index', ['data' => $this->Data()]); */
    }

    public function create(){
       
    }

    
    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
       
        
        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();
        $this->categoryList = $this->settingModel->setting_stock_category;
    }
    
    private function Data(){

        return [
            'authenticatedUser' => $this->authenticatedUser,
            'categoryList' => $this->categoryList,
            'stockList' => $this->stockList,
            'userModel' => $this->userModel,
            'personModel' => $this->personModel,
            'sessionCartList' => $this->sessionCartList,
            'schemeList' => $this->schemeList
        ];
    }

  
}
