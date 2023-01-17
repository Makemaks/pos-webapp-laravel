<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Models\User;
use App\Models\Setting;

use App\Models\Stock;
use App\Models\Store;
use App\Helpers\MathHelper;

class CartAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $stockList;
    private $userModel;
    private $personModel;
    private $cartList;
    private $setupList;
    private $settingModel;
    private $userList;
   
    private $personList;
    private $discount;
    private $html;
    private $requestInput;
   
    public function index(Request $request)
    {
        $this->init();
        $this->request = $request;
        $request->session()->forget('type');

        

        if($request->has('edit_cart')){
            if ($request['edit_cart'] == 'true') {
                $request->session()->flash('edit_cart', $request['edit_cart']);
            } else {
                $request->session()->forget('edit_cart', $request['edit_cart']);
            }
            
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
            return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }

    
        //voucher
        elseif ($request->has('searchInputID') && $request->session()->has('setting_setting_key')) {
            $request->session()->reflash('setting_setting_key');
            $request->session()->flash('searchInputID', $request['searchInputID']);

            $this->html = view('home.partial.settingKeyPartial', ['data' => $this->Data()])->render();
            return response()->json(['view' => $this->view, 'success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }
        elseif ($request['action'] == 'setupList' && $request->has('type')) {
            $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.setupList');

            if ( $request->session()->has('type') == false ) {
                $request->session()->flash('type', $request['type']);
            }

            $this->html = view('home.partial.setupListPartial', ['data' => $this->Data()])->render();
            return response()->json([
               
                'action' => $request['action'], 
                'type' => $request['type'], 
                'success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }
        else{
            if($request->session()->has('user-session-'.Auth::user()->user_id.'.cartList')){
                //remove session
                $request->session()->pull('user-session-'.Auth::user()->user_id.'.cartList.'.$id);
                
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //called by ajax
     public function Store(Request $request){

        //$request->session()->forget('type');
        $this->init();
        $this->request = $request;
       
        $this->view = 'receiptID';
        $type = '';
        $action = '';

        //add product to list
        if ($request->has('searchInputID')) {

             $this->stockModel = Stock::
             where('stock_merchandise->outer_barcode', $request['searchInputID'])
             ->orWhere('stock_merchandise->outer_barcode', 'like', '%'.$request['searchInputID'].'%')
             ->first();
            
            if ($this->stockModel) {
                $stock = Stock::find($this->stockModel);
                $store = Store::find(1);
                $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.setupList');
    
                $this->requestInput = Stock::StockInitialize($stock, $store, $setupList);

                $request->session()->push('user-session-'.Auth::user()->user_id.'.cartList', $this->requestInput);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.cartList');
            }

            
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('stock_id')) {

            //add to cart
            $this->cartList = $request->session()->get('user-session-'.Auth::user()->user_id.'.cartList');
            $stock = Stock::find($request['stock_id']);
            $store = Store::find($request['store_id']);
            $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.setupList');

            $this->requestInput = Stock::StockInitialize($stock, $store,  $this->setupList);

            
            $request->session()->push('user-session-'.Auth::user()->user_id.'.cartList', $this->requestInput);
            $this->cartList = $request->session()->get('user-session-'.Auth::user()->user_id.'.cartList');

            $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.setupList');

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();

        }

        elseif($request->has('action') && $request['action'] == 'float'){

            $request->session()->push('user-session-'.Auth::user()->user_id.'.setupList'.'.'.$request['action'], $request->all());
            $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.setupList'.'.'.$request['action']);
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        return response()->json([
            'view' => $this->view,
            'type' => $type,
            'action' => $action,
            'success'=>'Got Simple Ajax Request.', 
            'html' => $this->html
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$a = $request->all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$a = $request->all();
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
      
        $this->init();
        $key = key($request->all());
        if($request->has('stock_quantity')){

            $this->cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.cartList'); 
            $this->cartList[$id][$key] = $request[$key];  
            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList', $this->cartList);
            

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->init();
        $this->request = $request;
        $type = $request->session()->get('type');
        $action = 'setupList';

        if($request->session()->has('type') == false && $request->session()->has('user-session-'.Auth::user()->user_id.'.cartList')){
            //remove session
            $this->cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.cartList'); 

            unset($this->cartList[$id]);
            $this->cartList = array_values($this->cartList);

            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList', $this->cartList);

           
        }
        elseif ($request->has('order_setting_key')) {
          
             //remove session
             $this->setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.setupList'); 

             unset($this->setupList[ 'order_setting_key' ][$id]);
            
 
             $request->session()->put('user-session-'.Auth::user()->user_id.'.setupList', $this->setupList);
 
             $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
            
        }
        /* elseif ($request->session()->has('type') && $id == 'null') {
          
            //remove session
            $this->setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.setupList'); 

            $this->setupList[  $request->session()->get('type')  ]= [];
         

            $request->session()->put('user-session-'.Auth::user()->user_id.'.setupList', $this->setupList);

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
       } */


       return response()->json([
        'action' => $action, 
        'type' => $type, 
        'success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
      
    }

    private function Data(){

        return [
           
            'stockList' => $this->stockList,
            'userModel' => $this->userModel,
            'personModel' => $this->personModel,
            'cartList' => $this->cartList,
            'setupList' => $this->setupList,
            'settingModel' => $this->settingModel,
            'userList' => $this->userList,
            'personModel' => $this->personModel,
            'personList' => $this->personList,
            'requestInput' => $this->requestInput
        ];
    }


    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();

        
    }

}


