<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Helpers\MathHelper;
use Illuminate\Support\Facades\Auth;
use Session;
use Carbon\Carbon;

use App\Models\Setting;
use App\Models\User;
use App\Models\Store;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';
    protected $primaryKey = 'stock_id';

    //creates default value
    public $timestamps = true;

    protected $attributes = [

        'stock_store_id' => 1,
        "stock_price" => '{
            "1": {
                "price": "",
                "setting_stock_price_level": "",
                "setting_stock_price_group": "",
                "is_special_price" : ""
            }
        }',

        'stock_price_quantity' => '{
            "1": "{
                "stock_price_quantity": "",
                "setting_stock_price_group": ""
            }"
        }',

        "stock_supplier" => '{
            "1": {
                "supplier_id": "",
                "code": "",
                "unit_cost": "",
                "case_cost": ""

            }
        }',

        "stock_gross_profit" => '{
            "rrp": "",
            "actual": "",
            "target": "",
            "average_cost": ""
        }',



        "stock_merchandise" => '{
            "group_id": "",
            "category_id":"",
            "brand_id":"",

            "random_code": "",
            "expiration_date": "",
            "alert_level:""

            "non_stock": 1,
            "unit_size": "",
            "recipe_link": "",
            "case_size": "",
            "plu_id": {},

            "alternative_text": "",
            "current_stock": "",
            "days_to_order": "",
            "maximum_stock": "",
            "minimum_stock": "",
            "outer_barcode": "",
            "qty_adjustment": "",

            "setting_stock_vat": "",
            "stock_name": "",
            "stock_description": "",
            "stock_image": "",
            "stock_tag": "",
            "stock_type": "",

        }',


        "stock_terminal_flag" => '{
            "status_flag": {},
            "stock_control": {},
            "commission_rate": {},
            "kitchen_printer": {},
            "selective_itemiser": {}
        }',

        "stock_web" => '{
            "1": {
                "plu_id": {},
                "min": "",
                "max": "",
                "price": ""
            }
        }',

        'stock_allergen' => '{}',
        'stock_nutrition' => '{
            "setting_stock_id": "",
            "value": "",
            "measurement": ""
        }',


        "stock_setting_offer" => '{}',
        "stock_setting_vat" => '{}',

    ];


    protected $casts = [
        'stock_price' => 'array',
        'stock_price_quantity' => 'array',
        'stock_setting_vat' => 'array',
        'stock_setting_offer' => 'array',
        'special_stock_price' => 'array',
        'stock_supplier' => 'array',
        'stock_gross_profit' => 'array',
        "stock_merchandise" => 'array',
        "stock_terminal_flag" => 'array',
        "stock_web" => 'array',
        "stock_nutrition" => 'array',
        "stock_allergen" => 'array',
        "stock_price_quantity" => 'array',
        "stock_manager_special" => 'array'
    ];

    public static function Warehouse($column,  $filter){
        return Stock::
        leftJoin('warehouse', 'warehouse.warehouse_stock_id', '=', 'stock.stock_id')
            ->leftJoin('store', 'store.store_id', '=', 'warehouse.warehouse_store_id')
            ->where($column,  $filter);
    }

    public static function List()
    {

        return Stock::leftJoin('store', 'store.store_id', '=', 'stock.stock_store_id');
    }

    public static function GroupCategoryBrandPlu($data, $type, $stock_merchandise_key)
    {

        $totalPrice = 0;
        $price = 0;
        $departmentTotal = [];

        foreach ($data['settingModel']->setting_stock_set as $key => $value) {


            if ($value['type'] == $type) {

                $quantity = 0;
                $totalCostPrice = 0;

                foreach ($data['orderList'] as $orderList) {

                    $stock_merchandise = json_decode($orderList->stock_merchandise, true);


                    if ($orderList->receipt_id != null) {

                        if ($stock_merchandise[$stock_merchandise_key] == $key) {

                            $price = json_decode($orderList->receipt_stock_price, true);
                            $totalPrice = $totalPrice + head($price)['price'] * $orderList->receipt_stock_quantity;
                            $quantity = $quantity + $orderList->receipt_stock_quantity;

                            if($quantity != 0)
                                $totalCostPrice = $totalCostPrice + head($price)['price'] * $quantity;

                        }

                    }


                }


                $departmentTotal[] = [
                    'name' => $value['name'],
                    'Quantity' => $quantity,
                    'Total' => MathHelper::FloatRoundUp($totalPrice, 2),
                ];
            }
        }
        return $departmentTotal;
    }


    public static function OrderTotal($orderList)
    {

        $price = 0;
        $totalPrice = 0;

        foreach ($orderList as $receiptList) {
            $totalPrice = Stock::ReceiptTotal($receiptList, $totalPrice);
        }

        return $totalPrice;
    }


    public static function ReceiptTotal($receiptList, $totalPrice)
    {

        $price = 0;
        $stock_price = $receiptList->receipt_stock_price;

        if ($receiptList->receipt_discount) {

            $price = Stock::Discount($stock_price, $receiptList->receipt_discount)['total'];
        }

        $price = $price * $receiptList->receipt_stock_quantity;
        $totalPrice = $totalPrice + $price;

        return $totalPrice;
    }


    public static function Discount($stock_price, $discount){
        //enter discount manually
        $price = 0;

        foreach (json_decode($discount) as $keyOverride => $valueDiscount) {

            if (Receipt::ReceiptPriceOverrideType()[ $valueDiscount->type ] == 'percentage') {
                //percentage at checkout
                $price = $price + MathHelper::Discount($discount_value, $stock_price)['total'];

            }
            elseif(Receipt::ReceiptPriceOverrideType()[ $valueDiscount->type ] == 'amount') {
                //minus the amount at checkout
                $price = $price + $stock_price - $discount_value;
            }
        }

        return $price;
    }

    public static function GrossProfitTotal($orderList){

        $stockModel = New Stock();

        $orderList->groupBy('stock_id');

        foreach ($orderList as $receiptList) {

            foreach ($stockModel->stock_gross_profit as $key => $value) {
                $stockModel->stock_gross_profit[$key] = $stockgrossProfit[$key] + $receiptList->stock_gross_profit[$key];
            }

            $stockModel->stock_id = $receiptList->stock_id;
            $stockModel->stock_description = $receiptList->stock_description;
        }

        return $totalPrice;

    }




    public static function StockVAT($stock_setting_vat){
        //get vat

        $stock_vat = [];
        $userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

        $settingModel = Setting::where('setting_account_id', $userModel->store_id)->first();

        foreach ($stock_setting_vat as $key => $stock_setting_vat_item) {
            $stock_vat[$stock_setting_vat_item] = $settingModel->setting_vat[$stock_setting_vat_item];
        }

        return $stock_vat;
    }


    public static function StockPriceQuantity($stock_price, $stock_quantity){
        return $stock_price * intval($stock_quantity);
    }

    //find the minum offer price
    public static function StockPriceMin($settingCurrentSettingOfferType){
        $min = collect( $settingCurrentSettingOfferType )->pluck('total')->min('price');
        return collect( $settingCurrentSettingOfferType )->where('total.price',  $min)->first();
    }

    public static function StockPriceDefault($stockInitialize, $data){

        $price = [];

        if ( count($data['setupList']['customer']) > 0) {

            $data['setupList']['requestInput']['setting_stock_price_level'] = array_key_first($data['customer']['settingModel']
                ->setting_stock_price_level);
            $data['setupList']['requestInput']['setting_stock_price_level'] = array_key_first($data['customer']['settingModel']
                ->setting_stock_price_group);
        }

        $collection = collect($stockInitialize)->where('setting_stock_price_level', $data['setupList']['requestInput']['setting_stock_price_level'])
            ->where('setting_stock_price_group', $data['setupList']['requestInput']['setting_stock_price_group'])->toArray();

        if ($collection) {
            $price = $collection;
        }

        return $price;

    }


    public static function StockPriceProcessed($stockInitialize, $data, $loop){

        $stockOffer = 0;
        $settingCurrentOffer = [];
        $stock_price = head($stockInitialize['stock_price'])['price'];

        $data['setupList']['stock_price'] = $stock_price;
        $data['setupList']['stock_price_total'] = $stock_price;

        //find discount
        if ( count($stockInitialize['stock_setting_offer']) > 0) {
            //find discount
            $data = Setting::SettingOffer($stockInitialize, $data);
        }

        if ( count($stockInitialize['stock_setting_key']) > 0 ) {
            $data = Setting::SettingKey( $data['setupList'], $stockInitialize['stock_setting_key'] );
            // $data['setupList']['stock_setting_key_total'] = $data['setupList']['stock_setting_key_total'] + $data['setupList']['setting_key_amount_total'];
            $data['setupList']['setting_key'] = $stockInitialize['stock_setting_key'];
            $data['setupList']['stock_setting_key'] = $stockInitialize['stock_setting_key'];

        }


        $data['setupList']['stock_price_processed'] = Stock::StockPriceQuantity( $data['setupList']['stock_price_processed'], $stockInitialize['stock_quantity']);


        if ( count($stockInitialize['stock_setting_vat']) > 0 ) {
            if ($loop->first) {
                $data['setupList']['stock_vat_amount_total'] = 0;
            }

            $data['setupList']['stock_setting_vat'] = Stock::StockVAT($stockInitialize['stock_setting_vat']); //vat on this item
            $data['setupList']['stock_vat_rate'] = collect($data['setupList']['stock_setting_vat'])->sum('rate');
            $data['setupList']['stock_vat_rate_total'] = $data['setupList']['stock_vat_rate_total'] + $data['setupList']['stock_vat_rate'];
            $data['setupList']['stock_vat_amount'] = MathHelper::VAT($data['setupList']['stock_vat_rate'], $data['setupList']['stock_price_processed'] );
            $data['setupList']['stock_vat_amount_total'] = $data['setupList']['stock_vat_amount_total'] + $data['setupList']['stock_vat_amount'];

        }else{

            $data['setupList']['stock_vat_rate'] = collect($data['settingModel']->setting_vat)->where('default', 0)->first()['rate'];
            $data['setupList']['stock_vat_amount'] = MathHelper::VAT($data['setupList']['stock_vat_rate'], $data['setupList']['stock_price_processed'] );
            $data['setupList']['order_vat_amount_total'] = $data['setupList']['order_vat_amount_total'] + $data['setupList']['stock_vat_amount'];
        }


        $data['setupList']['stock_price_total'] = $data['setupList']['stock_price_processed'] + $data['setupList']['stock_vat_amount'];


        return $data;
    }

    public static function StockInitialize($stock, $store, $data){

        $stockInitialize = [

            'stock_id' => $stock->stock_id,
            'stock_price' => Stock::StockPriceDefault($stock->stock_price, $data),
            'stock_name' =>  $stock->stock_merchandise['stock_name'],
            'store_id' =>  $store->store_id,
            'store_name' =>  Store::find($store->store_id)->store_name,
            'stock_quantity' =>  1,
            'stock_setting_vat' => $stock->stock_setting_vat,
            'stock_setting_offer' => $stock->stock_setting_offer,
            'stock_setting_key' => [],
            'warehouse_store_id' => $stock->warehouse_id,
            'user_id' => Auth::user()->user_id
        ];

        return $stockInitialize;
    }

    public static function ReceiptInitialize($stock, $store, $data){


        $data['setupList']['stock']['stock_id'] = $stock->stock_id;
        $data['setupList']['stock']['stock_name'] = $stock->stock_merchandise['stock_name'];
        $data['setupList']['stock']['store_id'] = $store->store_id;
        $data['setupList']['stock']['store_name'] = Store::find($store->store_id)->store_name;
        $data['setupList']['stock']['stock_quantity'] = 1;
        $data['setupList'] = Stock::StockPriceProcessed($stock, $data);

        return $data;
    }

    public static function StockOffer(){
        return [
            "Discount %",
            "Set Price",
            "Discount amount cheapest",
            "Discount % cheapest",
            "Discount amount expensive",
            "Discount % expensive",
            "Discount amount last item",
            "Discount % last item"
        ];
    }

    public static function OfferStatus()
    {
        return [
            'Enabled',
            'Disabled'
        ];
    }

    public static function StockWarehouse($data, $stockItem){

        //get stock from other stores
        $storeList = Store::List('store_id', $stockItem['warehouse_store_id'])
            ->orWhere('root_store_id', $stockItem['warehouse_store_id'])
            ->select('store_id')
            ->get();


        $data['warehouseList'] = Stock::Warehouse('warehouse_stock_id', $stockItem['stock_id'])
            ->whereIn('warehouse_store_id', $storeList->toArray())
            ->where('warehouse_stock_quantity', '>', 0)
            //->where('warehouse_type', 2)
            ->get()
            ->groupBy('warehouse_store_id');

        return $data;
    }


}
