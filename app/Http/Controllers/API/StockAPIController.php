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
use App\Models\Receipt;
use App\Helpers\MathHelper;

class StockAPIController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private $userModel;
     private $setupList;
     private $personModel;
     private $stockList;
     private $orderList;
     private $authenticatedUser;
     private $categoryList;
     private $userList;
  

    public function index(Request $request)
    {

        $this->init();
        $a = $request['stockFormID'];
        $requestInput = [];

        parse_str($request['stockFormID'], $requestInput);

        if ($request->has('stockFormID')) {

            if($request->has('id') && $request->has('type') && $request['view'] == null){

                $request->session()->flash('id', $request['id']);
    
                $setting_stock_set = collect($this->settingModel->setting_stock_set)->where('type', $request->get('id'));
                $this->settingModel->setting_stock_set = $setting_stock_set;
                
                $this->html = view('stock.partial.groupPartial', ['data' => $this->Data()])->render();
            }
    
           elseif ( array_key_exists('setting_stock_price_group', $requestInput) &&  array_key_exists('setting_stock_price_level', $requestInput)){
               
                if ( $request->session()->has('user-session-'.Auth::user()->user_id.'.setupList')) {
                    $this->setupList = $request->session()->pull('user-session-'.Auth::user()->user_id.'.setupList');
                    $this->setupList['requestInput'] = $requestInput;
                    $request->session()->put('user-session-'.Auth::user()->user_id.'.setupList', $this->setupList);
                }
                

                $this->stockList = Stock::Warehouse('warehouse_store_id', $this->userModel->store_id)
                ->groupBy('stock_id')
                //->where('warehouse_stock_quantity', '>', 0)
                ->paginate(20);
    
                $this->html = view('home.partial.stockPartial', ['data' => $this->Data()])->render();
           }
           elseif ($request->has('action') && $request['action'] == 'showStock' || $request['view'] == "0") {
                
                $this->stockList = Stock::Warehouse('warehouse_store_id', $this->userModel->store_id)
                ->groupBy('stock_id')
                //->where('warehouse_stock_quantity', '>', 0)
                ->paginate(24);
    
            if ($request->has('view')) {
                    $this->stockList = $this->stockList->orWhere('stock_merchandise->stock_name', 'like', '%'.$request['value'].'%');
            }
            
            $this->stockList = $this->stockList->paginate(9);
            
                $this->html = view('home.partial.stockPartial', ['data' => $this->Data()])->render();
            }
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
        $a = 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $a = 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
    }

    private function init(){
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();
        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();
        $this->storeModel = Store::find($this->userModel->store_id);
        
    }

    
    private function Data(){

        return [
            'authenticatedUser' => $this->authenticatedUser,
            'stockList' => $this->stockList,
            'userModel' => $this->userModel,
            'personModel' => $this->personModel,
            'orderList' => $this->orderList,
            'settingModel' => $this->settingModel,
            'userList' => $this->userList,
            'setupList' => $this->setupList,
            'storeModel' => $this->storeModel
        ];
    }
}
