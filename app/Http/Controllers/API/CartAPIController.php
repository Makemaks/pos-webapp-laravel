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
    private $sessionCartList;
    private $settingModel;
    private $userList;
   
    private $personList;
    private $discount;
    private $html = '';

   
    public function index(Request $request)
    {
     
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
        elseif($request->has('plan_discount_code')){
            if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
                //remove session
              
                $requestInput = $request->except('_token', '_method');

                $this->userModel = User::Person('user_person_id', Auth::user()->user_person_id)
                ->first();

                /* $planModel = Plan::List('plan_account_id', $this->userModel->person_account_id)
                ->where('plan_discount_code', $requestInput['plan_discount_code'])
                ->first(); */

                //$request->session()->push('user-session-'.Auth::user()->user_id.'.'.'planList', $planModel->plan_id);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'planList');


                //$this->discount = MathHelper::Discount($planModel->plan_value, $request->totalPrice);

                return response()->json([
                    'success'=>'Got Simple Ajax Request.', 
                    'discount' => $this->discount
                ]);
            }
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

        if ($request->has('barcode')) {
             $this->stockModel = Stock::
             where('stock_merchandise->outer_barcode', $request['barcode'])
             ->orWhere('stock_merchandise->outer_barcode', 'like', '%'.$request['barcode'].'%')
             ->first();
            
            if ($this->stockModel) {
                $requestInput['stock_id'] = $this->stockModel->stock_id;
                $requestInput['stock_name'] = $this->stockModel->stock_merchandise['stock_name'];
                $requestInput['stock_price'] = $this->stockModel->stock_cost[1][1]['price'];
                $requestInput['stock_quantity'] = 1;
                $requestInput['stock_vat'] = $this->stockModel->stock_vat;
                //$requestInput['plan'] = '';

                $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartList', $requestInput);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList');
            }

        }else{
            $requestInput = $request->except('_token', '_method');
            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartList', $requestInput);
            
            //$value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList');
            
        }

            

           
        $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);

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
      
        if($request->has('quantity')){

            $this->cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList'); 
            $this->cartList[$id]['stock_quantity'] = $request['quantity'];  
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
        if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
            //remove session
            $this->cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList'); 

            unset($this->cartList[$id]);
            $this->cartList = array_values($this->cartList);

            $request->session()->put('user-session-'.Auth::user()->user_id.'.cartList', $this->cartList);

            $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
        }


        return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
    }

    private function Data(){

        return [
           
            'stockList' => $this->stockList,
            'userModel' => $this->userModel,
            'personModel' => $this->personModel,
            'sessionCartList' => $this->sessionCartList,
            'settingModel' => $this->settingModel,
            'userList' => $this->userList,
            'personModel' => $this->personModel,
            'personList' => $this->personList
        ];
    }


    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->settingModel = Setting::where('setting_store_id', $this->userModel->store_id)->first();
    }

}
