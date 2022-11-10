<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\User;
use App\Models\Store;
use App\Models\Setting;
use App\Models\Account;
use App\Models\Company;

class WarehouseController extends Controller
{

    private $userModel;
    private $stockList;
    private $storeList;
    private $stockModel;
    private $categoryList;
    private $settingModel;
    private $fileModel;
    private $companyList;
    private $warehouseModel;
    private $warehouseList;
    private $storeModel;




    public function Index(Request $request)
    {

        $this->Init();

        $this->warehouseModel = new Warehouse();
        $request->session()->reflash('view');
        $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)->get();

        if ($request->has('action')) {
            $warehouse = Warehouse::find($request->warehouse_id);
            $warehouse_quantity = $warehouse->warehouse_quantity - $request->receipt_quantity;
            Warehouse::where('warehouse_id', $request->warehouse_id)->update(['warehouse_quantity' => $warehouse_quantity]);
            return redirect()->back();
        }

        if ($request->session()->has('view') && $request->session()->get('view') == 'Ins-&-Out') {
            $this->warehouseList =  Warehouse::Store()
                ->orwhere('warehouse_type', 'In')
                ->orwhere('warehouse_type', 'Out')
                ->paginate(20);
        } elseif ($request->session()->has('view') && $request->session()->get('view') != 'Ins-&-Out') {

            $warehouse_type = array_search($request->session()->get('view'), Warehouse::WarehouseType());
            $this->warehouseList =  Warehouse::where('warehouse_type', $warehouse_type);
        } else {

            $accountList = User::Account('store_id',  $this->userModel->store_id)
                ->where('person_type', 0)
                ->get();

            $this->warehouseList = Warehouse::Store()
                ->whereIn('warehouse_user_id', $accountList->pluck('user_id'))
                ->paginate(20);

            $this->Init();
        }
        if ($request->session()->has('view') && $request->session()->get('view') == 'variance') {
            return view('warehouse.variance.index', ['data' => $this->Data()]);
        } else {
            return view('warehouse.index', ['data' => $this->Data()]);
        }
        
    }

    /**
     * This function adjust the warehoust quantity
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function AdjustQuantity(Request $request)
    {
        if ($request->has('receipt_quantity')) {
            foreach ($request->warehouse_id as $wareHouseKey => $warehouseId) {
                foreach ($request->receipt_quantity as $receiptQuantityKey => $receiptQuantity) {
                    if ($wareHouseKey == $receiptQuantityKey) {
                        $warehouse = Warehouse::find($warehouseId);
                        $warehouse_quantity = $warehouse->warehouse_quantity - $receiptQuantity;
                        Warehouse::where('warehouse_id', $warehouseId)->update(['warehouse_quantity' => $warehouse_quantity]);
                    }
                }
            }
            return redirect()->back();
        }
    }

    public function Create()
    {

        $this->warehouseModel = new warehouse();
        return view('warehouse.create', ['data' => $this->Data()]);
    }

    public function Store(Request $request)
    {   
        $this->Init();
        if ($request->has('is_update_request')) { 
            Warehouse::where('warehouse_id',$request->warehouse_id)->update(['warehouse_inventory'=>$request->form['warehouse']]);
            return redirect()->back();
        }
        if ($request->has('is_delete_request')) { 
            foreach($request->warehouse as $warehouseData) {
                if(isset($warehouseData['checked_row'])) {
                    Warehouse::where('warehouse_id', $warehouseData['warehouse_id'])->delete();
                }
            }
            return redirect()->back();
        }

        if ($request->has('store_from_index')) { 
            foreach($request->warehouse as $warehouseData) {
                $update = [
                    'warehouse_note' => $warehouseData['warehouse_note'],
                    'warehouse_reference' => $warehouseData['warehouse_reference'],
                    'warehouse_cost_override' => $warehouseData['warehouse_cost_override'],
                    'warehouse_quantity' => $warehouseData['warehouse_quantity'],
                    'warehouse_status' => $warehouseData['warehouse_status'],
                    'warehouse_type' => $warehouseData['warehouse_type'],
                    'warehouse_cost_type' => $warehouseData['warehouse_cost_type'],
                ];
                Warehouse::where('warehouse_id', $warehouseData['warehouse_id'])->update($update);
            }
            return redirect()->back();
        }
        
        if ($request->has('warehouse_form')) {

            $warehouseList = Warehouse::where('warehouse_stock_id', $request->warehouse_stock_id)
            ->where('warehouse_type',1)
            ->where('warehouse_store_id',$this->userModel->store_id)
            ->orwhere('warehouse_type',2)
            ->where('warehouse_quantity','>',0)
            ->get();

            $warehouseStore = [
                'warehouse_quantity' => $warehouseList->sum('warehouse_quantity'),
                'warehouse_status' => 0,
                'warehouse_type' => 5,
                'warehouse_store_id' => $this->userModel->store_id,
                'warehouse_stock_id' => $request->warehouse_stock_id,
                'warehouse_user_id' => $this->userModel->user_id,
                'warehouse_inventory' => $request->form['warehouse'],
                'warehouse_cost_type' => 0
            ];
            Warehouse::create($warehouseStore);
            return redirect()->back();
        }


        if ($request->has('receipt_quantity')) {
            foreach ($request->warehouse_id as $wareHouseKey => $warehouseId) {
                foreach ($request->receipt_quantity as $receiptQuantityKey => $receiptQuantity) {
                    if ($wareHouseKey == $receiptQuantityKey) {
                        $warehouse = Warehouse::find($warehouseId);
                        $warehouse_quantity = $warehouse->warehouse_quantity - $receiptQuantity;
                        Warehouse::where('warehouse_id', $warehouseId)->update(['warehouse_quantity' => $warehouse_quantity]);
                    }
                }
            }
            return redirect()->back();
        }
        Warehouse::insert($request->except('_token', '_method'));
        return view('warehouse.index', ['data' => $this->Data()]);
    }

    public function Edit($warehouse)
    {   
        $this->Init();
        $warehouseData = Warehouse::where('warehouse_id',$warehouse)->first();
        $this->warehouseList = Warehouse::where('warehouse_id', $warehouse)->get();
        $this->stockModel = Stock::find($this->warehouseList->first()->warehouse_stock_id);
        $this->stockList = Stock::List('stock_store_id', $this->userModel->store_id)->get();
        $this->warehouseModel = new Warehouse();

        return view('warehouse.edit', ['data' => $this->Data(),'warehouseData'=>$warehouseData]);
    }

    public function Update(Request $request, $warehouse)
    {

        Warehouse::find($warehouse)
            ->update($request->except('_token', '_method'));

        return view('warehouse.edit', ['data' => $this->Data()]);
    }

    public function Destroy($warehouse)
    {
        Warehouse::destroy($warehouse);
        PersonWarehouse::where('person_warehouse_warehouse_id', $warehouse)
            ->destroy();

        return redirect()->route('warehouse.index');
    }

    private function Init()
    {
        $this->userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

        $this->companyList  = Company::Store('company_store_id', $this->userModel->store_id)->get();

        $this->settingModel = Setting::where('settingtable_id', $this->userModel->store_id)->first();
        $this->settingModel = Setting::find($this->settingModel->setting_id);

        $this->categoryList = $this->settingModel->setting_stock_category;


        $this->storeList = Store::List('root_store_id', $this->userModel->store_id);

        $this->storeModel = Store::Account('store_id', $this->userModel->store_id)
            ->first();

        //$this->storeList->prepend($storeModel);
    }


    private function Data()
    {

        return [

            'userModel' => $this->userModel,
            'categoryList' => $this->categoryList,
            'stockList' => $this->stockList,
            'stockModel' => $this->stockModel,
            'settingModel' =>  $this->settingModel,
            'fileModel' => $this->fileModel,
            'storeList' => $this->storeList,
            'storeModel' => $this->storeModel,
            'companyList' => $this->companyList,
            'warehouseList' => $this->warehouseList,
            'warehouseModel' => $this->warehouseModel
        ];
    }
}
