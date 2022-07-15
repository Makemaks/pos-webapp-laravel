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
        $request->session()->flash('action', $request['action']);
        $request->session()->flash('view', 0);
        $this->init();
        

        $this->userList = User::Store('person_user_id', $this->userModel->user_id)
        ->orderBy('person_name->person_firstname')
        ->get();

        if($request->has('id') && $request->has('type') && $request['view'] == null){

            $request->session()->flash('id', $request['id']);

            $setting_stock_group = collect($this->settingModel->setting_stock_group)->where('type', $request->get('id'));
            $this->settingModel->setting_stock_group = $setting_stock_group;
            
            $this->html = view('stock.partial.groupPartial', ['data' => $this->Data()])->render();
        }
        elseif ($request->has('id') && $request->has('view') || $request['action'] == "0" ) {
            
           
            //used for pagination
            if ($request->has('id')) {
                $request->session()->flash('id', $request['id']);
                $request->session()->flash('type', $request['type']);
            } else {
                $request->session()->reflash('id');
                $request->session()->reflash('type');
            }
            
            $request->session()->flash('view', $request['view']);
            $request->session()->flash('action', 0);

            $setting_stock_group = $this->settingModel->setting_stock_group[$request->session()->get('id')];

            $setting_stock_group = collect($this->settingModel->setting_stock_group)->where('type', $setting_stock_group['type']);
            $this->settingModel->setting_stock_group = $setting_stock_group;

            
            $where = 'stock_merchandise->'.$request->session()->get('type').'_id';
            
            $this->stockList = Stock::Warehouse($where, $this->userModel->store_id)
            ->groupBy('stock_id')
            ->where('warehouse_quantity', '>', 0)
            ->where($where, $request->session()->get('id'))
            ->paginate(20);

            $this->html = view('stock.partial.indexPartial', ['data' => $this->Data()])->render();
            //$this->html = view('stock.partial.groupPartial', ['data' => $this->Data()])->render();
        } 
        //remove session person_id
       
        elseif ($request->has('action') && $request['action'] == 'showKeypad') {
           
            $this->html = view('partial.numpadPartial', ['type' => $request->type])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'useCustomer') {
           

            $setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'setupList')[0];
            $setupList['customer'] = $request->all();

            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'setupList', $setupList);
          
            $this->personModel = Person::find($request['value']);

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
          
        }

        elseif ($request->has('action') && $request['action'] == 'createCustomer') {
           
            $data['personModel'] = new Person();
           
            $this->html = view('person.partial.createPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'showCustomer') {
           
            $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');

            $this->personList = Person::Address('person_organisation_id', $this->userModel->organisation_id)
            ->paginate(20);

            $this->html = view('person.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'removeCustomer') {
            $setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'setupList')[0];
            $setupList['customer'] = [];
            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'setupList', $setupList);

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'searchCustomer') {
            
            $userList = User::Store('user_account_id', $this->userModel->account_id)->pluck('user_id');
            $this->personList = Person::whereIn('person_user_id', $userList)
            ->orWhere('person_name->person_firstname', 'like', '%'.$request['value'].'%')
            ->orWhere('person_name->person_lastname', 'like', '%'.$request['value'].'%')
            ->paginate(20);
           
            $this->html = view('person.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'showStock' || $request['view'] == "0") {
            
            $this->stockList = Stock::Warehouse('stock_store_id', $this->userModel->store_id)
            ->groupBy('stock_id')
            ->where('warehouse_quantity', '>', 0);

           if ($request->has('view')) {
                $this->stockList = $this->stockList->orWhere('stock_merchandise->stock_name', 'like', '%'.$request['value'].'%');
           }
           
           $this->stockList = $this->stockList->paginate(20);
           
            $this->html = view('stock.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('action') && $request['action'] == 'showOrder' || $request['view'] == "0") {
            
          
            $this->orderList = Receipt::Order('stock_store_id',  $this->userModel->store_id)
            ->orderByDesc('order_id')
            ->groupBy('order_id')
            ->paginate(20);

       
           
            $this->html = view('order.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        

        //retrieve person_id
        elseif($request->has('action') && $request['action'] == 'searchCustomer'){
          
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
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();

       
    }

    
    private function Data(){

        return [
            'authenticatedUser' => $this->authenticatedUser,
            'stockList' => $this->stockList,
            'userModel' => $this->userModel,
            'personModel' => $this->personModel,
            'sessionCartList' => $this->sessionCartList,
            'orderList' => $this->orderList,
            'settingModel' => $this->settingModel,
            'userList' => $this->userList,
            'personModel' => $this->personModel,
            'personList' => $this->personList,
            'request' => $this->request
        ];
    }
}
