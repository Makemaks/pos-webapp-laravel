<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Scheme;
use App\Models\Plan;
use App\Helpers\MathHelper;

class CartAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $userModel;

    public function index(Request $request)
    {
     
        if($request->has('scheme_id')){
            if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
                //remove session
              
                $requestInput = $request->except('_token', '_method');

                $schemeModel = Scheme::List('scheme_id', $request->scheme_id)->first();


                $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'schemeList', $request->scheme_id);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'schemeList');

                $discount = Plan::CalculatePlanType($schemeModel);

                return response()->json([
                    'success'=>'Got Simple Ajax Request.', 
                    'discount' => $discount
                ]);

            }
        }
        elseif($request->has('plan_discount_code')){
            if($request->session()->has('user-session-'.Auth::user()->user_id.'.'.'cartList')){
                //remove session
              
                $requestInput = $request->except('_token', '_method');

                $this->userModel = User::Person('user_person_id', Auth::user()->user_person_id)
                ->first();

                $planModel = Plan::List('plan_account_id', $this->userModel->person_account_id)
                ->where('plan_discount_code', $requestInput['plan_discount_code'])
                ->first();

                $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'planList', $planModel->plan_id);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'planList');


                $discount = MathHelper::Discount($planModel->plan_value, $request->totalPrice);

                return response()->json([
                    'success'=>'Got Simple Ajax Request.', 
                    'discount' => $discount
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

      
        if ($request->has('barcode')) {
            $productModel = Product::where('product_barcode', $request['barcode'])->first();
            
            if ($productModel) {
                $requestInput['product'] = $productModel->product_id;
                $requestInput['name'] = $productModel->product_name;
                $requestInput['price'] = $productModel->product_price;
                $requestInput['quantity'] = '';
                $requestInput['plan'] = '';

                $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartList', $requestInput);
                $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList');
            }

        }else{
            $requestInput = $request->except('_token', '_method');
            $request->session()->push('user-session-'.Auth::user()->user_id.'.'.'cartList', $requestInput);
            $value = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList');
        }

            

           

        return response()->json(['success'=>'Got Simple Ajax Request.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $a = $request->all();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $a = $request->all();
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

        $a = $request->all();
      
        if($request->has('quantityID')){
            $this->cartList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList'); 

            $pos = array_search($request['quantityID'], $this->cartList);      
             
            $a = $request->session()->pull('user-session-'.Auth::user()->user_id.'.cartList.'.$id);
        }
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
            $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList.'.$id);
        }

        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }

    

}
