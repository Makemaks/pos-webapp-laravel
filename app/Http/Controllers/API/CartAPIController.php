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
    private $html = '';
    private $view = 'contentID';
    private $request;
   
    public function index(Request $request)
    {
        $this->init();
        $this->request = $request;


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

        elseif($request->has('setting_finalise_key')){
            $request->session()->flash('setting_finalise_key', $request['setting_finalise_key']);
            
            $this->html = view('home.partial.settingFinaliseKeyPartial', ['data' => $this->Data()])->render();
            return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }
        //voucher
        elseif ($request->has('searchInputID') && $request->session()->has('setting_finalise_key')) {
            $request->session()->reflash('setting_finalise_key');
            $request->session()->flash('searchInputID', $request['searchInputID']);

            $this->html = view('home.partial.settingFinaliseKeyPartial', ['data' => $this->Data()])->render();
            return response()->json(['view' => $this->view, 'success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }
        elseif ($request['action'] == 'setupList' && $request->has('type')) {
            $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList');
            $request->session()->put('type', $request['type']);

            $this->html = view('home.partial.setupListPartial', ['data' => $this->Data()])->render();
            return response()->json(['view' => $this->view, 'success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
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

      
        $this->init();
        $this->request = $request;
        $a = $request->all();
        $this->view = 'receiptID';


        //add product to list
        if ($request->has('searchInputID') && $request->session()->has('setting_finalise_key') == false) {

             $this->stockModel = Stock::
             where('stock_merchandise->outer_barcode', $request['searchInputID'])
             ->orWhere('stock_merchandise->outer_barcode', 'like', '%'.$request['searchInputID'].'%')
             ->first();
            
            if ($this->stockModel) {
                $requestInput['stock_id'] = $this->stockModel->stock_id;
                $requestInput['user_id'] = $this->stockModel->user_id;
                $requestInput['stock_name'] = $this->stockModel->stock_merchandise['stock_name'];
                $requestInput['stock_cost'] = $this->stockModel->stock_cost[1][1]['price'];
                $requestInput['stock_quantity'] = 1;
                $requestInput['stock_discount'] = [];
               
           
                //$requestInput['plan'] = '';

                $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartList', $requestInput);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList');
            }

            
            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }

        elseif ($request->has('stock_id')) {

            //add to cart
            $requestInput = $request->all();
            $requestInput['stock_discount'] = [];
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
        elseif ( $request->has('type') && $request->has('value') ){

            //specific receipt
           if ( is_int($request['type']) ) {

                $cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList');
                $cartList[$request['type'] ]['stock_discount'] = $request['value'];

                $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartList', $cartList);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList');
                $request['type'] = 'discount';
                $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();

           }else{
                //$this->view = 'contentID';
                $request->session()->put('type', $request['type']);
                $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
                
           }

           return response()->json(['view' => $this->view, 'success' => $request['type'].'Added.', 'html' => $this->html]);

        }
        
      
        return response()->json(['view' => $this->view, 'success'=>'Got Simple Ajax Request.', 'html' => $this->html]);

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

        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $this->cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList'); 

            unset($this->cartList[$id]);
            $this->cartList = array_values($this->cartList);

            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList', $this->cartList);

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }
        elseif ($request->has('action') && $id != 0) {
          
             //remove session
             $this->setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'setupList'); 

             unset($this->setupList[$request['type']][$id]);
             $this->setupList = array_values($this->setupList);
 
             $request->session()->put('user-session-'.Auth::user()->user_id.'.setupList', $this->setupList);
 
             $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
            return response()->json(['view' => $this->view, 'success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
        }
        elseif ($request->has('action') && $id == 0) {
          
            //remove session
            $this->setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'setupList'); 

            $this->setupList[ $request['type'] ]= [];
         

            $request->session()->put('user-session-'.Auth::user()->user_id.'.setupList', $this->setupList);

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
           return response()->json(['view' => $this->view, 'success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
       }


        return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
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
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();

        
    }

}


