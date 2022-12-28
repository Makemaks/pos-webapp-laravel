<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

use App\Models\User;
use App\Models\Setting;

use App\Models\Stock;
use App\Helpers\MathHelper;

class SettingAPIController extends Controller
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
        private $settingList;
        private $personList;
        private $discount;
        private $html;
        private $requestInput;
  

    public function index(Request $request)
    {

        $a = $request->all();
        $this->Init();
        $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList'); 
       
        if ($request->has('settingKeyFormID')) {
            $requestInput = [];
            $setting_key = [];
            $settingModel = new Setting();
            //$settingModel->setting_id = $this->settingModel->setting_id;
          

            parse_str($request->get('settingKeyFormID'), $requestInput['settingKeyFormID']);
            $setting_key = ['0' => $requestInput['settingKeyFormID']['form']['setting_key']];

            if ($setting_key[0]['setting_key_group'] != '' && $setting_key[0]['setting_key_type'] != '') {
                $a = $this->settingModel->setting_key;
                $setting_key = collect($this->settingModel->setting_key)->where('setting_key_group', $setting_key[0]['setting_key_group'])
                ->where('setting_key_type', $setting_key[0]['setting_key_type'])->toArray();
            }

            
            $this->settingModel->setting_key = $setting_key;
          
            
            if(count( $this->setupList['order_setting_key']) ){

                $setting_key = $this->settingModel->setting_key->intersect($this->setupList['order_setting_key']);
                $this->settingModel->setting_key = $setting_key;
                
            }
            
            $this->html = view('setting.partial.settingKeyPartial', ['data' => $this->Data()])->render();
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
        if($request->has('settingKeyFormID')){
          
            $requestInput = [];
            parse_str($request->get('settingKeyFormID'), $requestInput['settingKeyFormID']);

            foreach ($requestInput['settingKeyFormID']['setting_key_id'] as $key => $value) {
                $a[$value] = $requestInput['settingKeyFormID']['setting_key'][$value] + [$key => $value];
            }
           
            
            foreach ($requestInput['settingKeyFormID']['setting_key'] as $setting_key_key => $setting_key_item) {
                if ( Arr::exists($setting_key_item, 'id') == false) {
                    Arr::pull($requestInput['settingKeyFormID']['setting_key'], $setting_key_key);
                }
            }


            if (count($requestInput['settingKeyFormID']['setting_key']) > 0) {
              
                if ($request->has('cartFormID')) {
                    //add setting_key to cart item
                    parse_str($request->get('cartFormID'), $requestInput['cartFormID']);
                    $cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList');
                   
                    foreach ($requestInput['cartFormID']['receipt_stock_id'] as $key => $receipt_setting_key) {
                        foreach ($cartList as $cart_key => $cart_Item) {
                            $cart_Item['receipt_setting_key'][$key] = $receipt_setting_key;
                        }
                    }

                    $request->session()->put('user-session-'.Auth::user()->user_id.'.'.'cartList', $this->cartList);
                }else{
                    //add setting_key to order
                    $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList'); 
                    $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'setupList');
                    $this->setupList['order_setting_key'] = $requestInput['settingKeyFormID']['setting_key'];
                    $request->session()->put('user-session-'.Auth::user()->user_id.'.'.'setupList', $this->setupList);
                }
            
              
                $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList'); 
                $this->cartList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList'); 

                $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
            }
            
        }
        
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
        $this->settingList = Setting::where('settingtable_id', $this->userModel->store_id);
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();
       
        
    }

    private function Data(){

        return [
           
            'stockList' => $this->stockList,
            'userModel' => $this->userModel,
            'personModel' => $this->personModel,
            'cartList' => $this->cartList,
            'setupList' => $this->setupList,
            'settingModel' => $this->settingModel,
            'settingList' => $this->settingList,
            'userList' => $this->userList,
            'personModel' => $this->personModel,
            'personList' => $this->personList,
            'requestInput' => $this->requestInput
        ];
    }
}
