<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        $this->init($request);
        

        $this->userList = User::Store('person_user_id', $this->userModel->user_id)
        ->orderBy('person_name->person_firstname')
        ->get();

        if($request->has('id') && $request->has('type') && $request['view'] == null){

            $setting_stock_group = collect($this->settingModel->setting_stock_group)->where('type', $request->get('id'));
            $this->settingModel->setting_stock_group = $setting_stock_group;
            
            $this->html = view('home.partial.stock-groupPartial', ['data' => $this->Data()])->render();
        }
        elseif ($request->has('id') && $request->has('view')) {
            
            $setting_stock_group = $this->settingModel->setting_stock_group[$request->get('id')];
            

            $setting_stock_group = collect($this->settingModel->setting_stock_group)->where('type', $setting_stock_group['type']);
            $this->settingModel->setting_stock_group = $setting_stock_group;

            $where = 'stock_merchandise->'.$request->get('type').'_id';
            $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)
            ->where($where, $request->get('id'))
            ->paginate(11);

            $this->html = view('home.partial.stock-groupPartial', ['data' => $this->Data()])->render();
        } 


        

        //remove session person_id
       
        elseif ($request->has('action') && $request['action'] == 'show_keypad') {
           
            $this->html = view('partial.numpadPartial', ['type' => 1])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'use_customer') {
           
            $this->personModel = Person::find($request['value']);
            $this->html = view('person.partial.personPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'create_customer') {
           
            $this->html = view('person.partial.createPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'show_customer') {
           
            $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');

            $this->personList = Person::whereIn('person_user_id', $userList)->paginate(20);
            $this->html = view('person.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'search_customer') {
            $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');
            $this->personList = Person::whereIn('person_user_id', $userList)
            ->orWhere('person_name->person_firstname', 'like', '%'.$request['value'].'%')
            ->orWhere('person_name->person_lastname', 'like', '%'.$request['value'].'%')
            ->paginate(20);
           
            $this->html = view('person.partial.indexPartial', ['data' => $this->Data()])->render();
        }


        //retrieve person_id
        elseif($request->has('person_id') || $request->has('person_id')){
          
            $this->personModel = Person::find($request->get('person_id'));
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
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
        
    }

    /**
     * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
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
            'userList' => $this->userList,
            'personModel' => $this->personModel,
            'personList' => $this->personList
        ];
    }
}
