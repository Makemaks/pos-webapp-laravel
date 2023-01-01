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
            $setting_key = ['1' => $requestInput['settingKeyFormID']['form']['setting_key']];

            if ($setting_key[1]['setting_key_group'] != '' && $setting_key[1]['setting_key_type'] != '') {
              
                foreach (collect($this->settingModel->setting_key) as $setting_key_list) {
                    if (head($setting_key_list)['setting_key_group'] == $setting_key[1]['setting_key_group'] && 
                    head($setting_key_list)['setting_key_type'] == $setting_key[1]['setting_key_type']) {
                        
                        $setting_key[1] = $setting_key_list;
                        break;
                    }
                }
                
            }

            
            $this->settingModel->setting_key = $setting_key;
            
        
            $this->html = view('setting.settingKey.create', ['data' => $this->Data()])->render();
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
          
            $this->init();
            $requestInput = [];
            $setting_key = [];
            parse_str($request->get('settingKeyFormID'), $requestInput['settingKeyFormID']);
            parse_str($request->get('cartFormID'), $requestInput['cartFormID']);
            $this->cartList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'cartList'); 

            if (count($requestInput['settingKeyFormID']['form']['setting_key']) > 0 && count($this->cartList) > 0) {
              
                //$requestInput['settingKeyFormID']['form']['setting_key'];
                if ( $request->has('cartFormID') && count($requestInput['cartFormID']) > 0 ) {
                    //add setting_key to cart item
                    $this->cartList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'cartList');
                    foreach ($requestInput['cartFormID']['receipt_stock_id'] as $key => $receipt_setting_key) {
                        foreach ($this->cartList as $cart_key => $cart_Item) {
                            $this->cartList[$cart_key]['receipt_setting_key'][$cart_key + 1] = $requestInput['settingKeyFormID']['form']['setting_key'];
                        }
                    }

                    $request->session()->put('user-session-'.Auth::user()->user_id.'.'.'cartList', $this->cartList);
                    
                }else{
                    //add setting_key to order
                    $this->setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.'.'setupList');
                    $this->setupList['order_setting_key'][ count($this->setupList['order_setting_key']) + 1 ] = [ $requestInput['settingKeyFormID']['setting_key_id'] => $requestInput['settingKeyFormID']['form']['setting_key'] ];
                    $request->session()->put('user-session-'.Auth::user()->user_id.'.'.'setupList', $this->setupList);
                    $this->settingModel->setting_key = $this->setupList['order_setting_key'];
                }
            
              
                $this->setupList = $request->session()->get('user-session-'.Auth::user()->user_id.'.'.'setupList'); 
               

                $this->html = view('receipt.partial.indexPartial', ['data' => $this->Data()])->render();
                return response()->json(['success'=>'Got Simple Ajax Request.', 'html' => $this->html]);
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
        $a = 1;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $a = 1;
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
        $a = 1;
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
        foreach ($requestInput['settingKeyFormID']['setting_key_id'] as $key => $value) {
            $a[$value] = $requestInput['settingKeyFormID']['setting_key'][$value] + [$key => $value];
        }
       
        
        foreach ($requestInput['settingKeyFormID']['setting_key'] as $setting_key_key => $setting_key_item) {
            if ( Arr::exists($setting_key_item, 'id') == false) {
                Arr::pull($requestInput['settingKeyFormID']['setting_key'], $setting_key_key);
            }
        }

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
