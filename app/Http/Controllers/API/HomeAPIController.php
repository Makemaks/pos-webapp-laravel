<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Store;
use App\Models\Stock;
use App\Models\Order;
use App\Models\User;
use App\Models\Person;
use App\Models\Setting;
use App\Models\Receipt;

class HomeAPIController extends Controller
{

         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    private $userModel;
    private $personModel;
    private $routeList;
    private $stockList;
    private $orderList;
    private $authenticatedUser;
    private $categoryList;
    private $userList;

    
    private $storeModel;
    private $settingModel;
    private $paymentModel;
    private $sessionCartList = [];
    private $schemeList;
    private $html;
    private $personList;
  

    public function index(Request $request)
    {

        //used for pagination
        $this->request = $request;

        $all = $request->all();
        
        $request->session()->flash('action', $request['action']);
        $request->session()->flash('view', 0);
        $this->init();
        

        $this->userList = User::Store('person_user_id', $this->userModel->user_id)
        ->orderBy('person_name->person_firstname')
        ->get();

        
        if($request->has('setting_setting_key')){
            $request->session()->flash('setting_setting_key', $request['setting_setting_key']);
            
            $this->html = view('home.partial.settingKeyPartial', ['data' => $this->Data()])->render();
            return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }
       
        elseif ($request->has('action') && $request['action'] == 'showKeypad') {
           
            $this->html = view('partial.numpadPartial', ['type' => $request->type])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'showOrder' || $request['view'] == "0") {
            
            $this->orderList = Receipt::Order('order_store_id', $this->userModel->store_id)
            ->orderByDesc('order_id')
            ->groupBy('order_id')
            ->paginate(20);
           
            $this->html = view('order.partial.indexPartial', ['data' => $this->Data()])->render();
        }
        
    
        return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
    }

    /**
     * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $hi = 1;
    }

    /**
     * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $hi = 1;
    }

    /**
     * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $hi = 1;
        //
    }

    /**
     * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $hi = 1;
    }

    /**
     * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $hi = 1;
        //
    }

    /**
     * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }

    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();

    }

    
    private function Data(){

        return [
            'authenticatedUser' => $this->authenticatedUser,
            'stockList' => $this->stockList,
            'userModel' => $this->userModel,
            'personModel' => $this->personModel,
            'cartList' => $this->sessionCartList,
            'orderList' => $this->orderList,
            'settingModel' => $this->settingModel,
            'userList' => $this->userList,
            'personModel' => $this->personModel,
            'personList' => $this->personList
        ];
    }
}
