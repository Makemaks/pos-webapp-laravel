<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Setting;

use App\Models\Stock;
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
    private $request;
   
    public function index(Request $request)
    {
        $this->init();
        $this->request = $request;
        $request->session()->forget('type');

        if($request->has('scheme_id')){
            if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
                //remove session
              
                $requestInput = $request->except('_token', '_method');

                //$schemeModel = Scheme::List('scheme_id', $request->scheme_id)->first();

                //$request->session()->push('user-session-'.Auth::user()->user_id.'.'.'schemeList', $request->scheme_id);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'schemeList');

                //$discount = Plan::CalculatePlanType($schemeModel);

                return response()->json([
                    'success'=>'Got Simple Ajax Request.', 
                    'discount' => $this->discount
                ]);

            }
        }

        elseif($request->has('edit_cart')){
            if ($request['edit_cart'] == 'true') {
                $request->session()->flash('edit_cart', $request['edit_cart']);
            } else {
                $request->session()->forget('edit_cart', $request['edit_cart']);
            }
            
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
            return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }

        elseif($request->has('setting_setting_key')){
            $request->session()->flash('setting_setting_key', $request['setting_setting_key']);
            
            $this->html = view('home.partial.settingFinaliseKeyPartial', ['data' => $this->Data()])->render();
            return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }
        //voucher
        elseif ($request->has('searchInputID') && $request->session()->has('setting_setting_key')) {
            $request->session()->reflash('setting_setting_key');
            $request->session()->flash('searchInputID', $request['searchInputID']);

            $this->html = view('home.partial.settingFinaliseKeyPartial', ['data' => $this->Data()])->render();
            return response()->json(['view' => $this->view, 'success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }
        elseif ($request['action'] == 'setupList' && $request->has('type')) {
            $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList');

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
            if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
                //remove session
                $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList.'.$id);
                
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
        $a = $request->all();
        $this->view = 'receiptID';
        $type = '';
        $action = '';

        //add product to list
        if ($request->has('searchInputID') && $request->session()->has('setting_setting_key') == false) {

             $this->stockModel = Stock::
             where('stock_set->outer_barcode', $request['searchInputID'])
             ->orWhere('stock_set->outer_barcode', 'like', '%'.$request['searchInputID'].'%')
             ->first();
            
            if ($this->stockModel) {
                $requestInput['stock_id'] = $this->stockModel->stock_id;
                $requestInput['user_id'] = $this->stockModel->user_id;
                $requestInput['stock_name'] = $this->stockModel->stock_set['stock_name'];
                $requestInput['stock_cost'] = $this->stockModel->stock_cost[1][1]['price'];
                $requestInput['stock_quantity'] = 1;
                $requestInput['stock_discount'] = 0;
               
           
                //$requestInput['plan'] = '';

                $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartList', $requestInput);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList');
            }

            
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('stock_id')) {

            //add to cart
            $requestInput = $request->all();
            $requestInput['stock_discount'] = 0;
            $requestInput += ['user_id' => Auth::user()->user_id];
           
            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartList', $requestInput);
            $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList');
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif($request->has('action') && $request['action'] == 'float'){
           

            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'setupList'.'.'.$request['action'], $request->all());
            $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList'.'.'.$request['action']);
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }
         //discount
        elseif ( $request->has('type') && $request->has('value') && $request->session()->has('type')){

            //specific receipt
            $aq = $request->session()->all();

           if ( $request->session()->get('type') != 'discountCartList' ) {
               //for end 
               $request->session()->reflash('type');
               $type = $request->session()->get('type');
               $action = 'setupList';
               $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();

           }
           else{
                //for receipt
                $cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList');
                $cartList[$request['type'] ]['stock_discount'] = $request['value'];

                $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartList', $cartList);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList');
                $request['type'] = 'discount';
                $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
               
           }

           //return response()->json(['view' => $this->view, 'success' => $request['type'].'Added.', 'html' => $this->html]);

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

            $this->cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList'); 
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

        if($request->session()->has('type') == false && $request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $this->cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList'); 

            unset($this->cartList[$id]);
            $this->cartList = array_values($this->cartList);

            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList', $this->cartList);

           
        }
        elseif ($request->session()->has('type') && $id != 'null') {
          
             //remove session
             $this->setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'setupList'); 

             unset($this->setupList[ $request->session()->get('type') ][$id]);
            
 
             $request->session()->put('user-session-'.Auth::user()->user_id.'.setupList', $this->setupList);
 
             $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
            
        }
        elseif ($request->session()->has('type') && $id == 'null') {
          
            //remove session
            $this->setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'setupList'); 

            $this->setupList[  $request->session()->get('type')  ]= [];
         

            $request->session()->put('user-session-'.Auth::user()->user_id.'.setupList', $this->setupList);

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
       }


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
            'request' => $this->request
        ];
    }


    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->settingModel = Setting::where('setting_account_id', $this->userModel->account_id)->first();

        
    }

}


