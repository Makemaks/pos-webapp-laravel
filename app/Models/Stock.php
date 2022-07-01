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

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';
    protected $primaryKey = 'stock_id';

    //creates default value
    protected $attributes = [

       

        'stock_store_id' => 1,
        "stock_cost" => '{
            "1": {
                "1": ""
            }
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
            "plu_id": "",
            
            "current_stock": "",
            "days_to_order": "",
            "maximum_stock": "",
            "minimum_stock": "",
            "outer_barcode": "",
            "qty_adjustment": "",
            
            "stock_vat_id": "",
            "stock_name": "",
            "stock_description": "",
            "stock_quantity": "",
            "stock_image": "",
            "stock_tag": "",
            "stock_offer_id": {},
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
                "plu": "",
                "min": "",
                "max": "",
                "price": ""
            }
        }',

        'stock_allergen' => '{}',
        'stock_nutrition' => '{
            "ref": "",
            "value": "",
            "measurement": ""
        }',
        'stock_cost_quantity' => '{
            "1": "1"
        }',

        'stock_manager_special' => '{
            "1": {
                "1": ""
            }
        }'


    ];


    protected $casts = [
        'stock_cost' => 'array',
        'stock_supplier' => 'array',
        'stock_gross_profit' => 'array',
        "stock_merchandise" => 'array',
        "stock_terminal_flag" => 'array',
        "stock_web" => 'array',
        "stock_nutrition" => 'array',
        "stock_allergen" => 'array',
        "stock_cost_quantity" => 'array',
        "stock_manager_special" => 'array'
    ];

    public static function Warehouse($column,  $filter){
        return Stock::
        leftJoin('warehouse', 'warehouse.warehouse_stock_id', '=', 'stock.stock_id')
        ->where($column,  $filter);
    }

    public static function List()
    {

        return Stock::leftJoin('store', 'store.store_id', '=', 'stock.stock_store_id');
    }


    public static function OfferStatus()
    {
        return [
            'Enabled',
            'Disabled'
        ];
    }

    public static function GroupCategoryBrandPlu($data, $type, $stock_merchandise_key)
    {

        $totalCostPrice = 0;
        $price = 0;
        $departmentTotal = [];

         foreach ($data['settingModel']->setting_stock_group as $key => $value) {

         

            if ($value['type'] == $type) {

                $quantity = 0;

                foreach ($data['orderList'] as $orderList) {

                    $stock_merchandise = json_decode($orderList->stock_merchandise, true);

                        if ($stock_merchandise[$stock_merchandise_key] == $key) {

                            $price = $orderList->receipt_stock_cost;

                            $totalCostPrice = $totalCostPrice + $price * $orderList->receipt_quantity;

                            $quantity = $quantity + $orderList->receipt_quantity;
                           
                        }
                   
                }


                $departmentTotal[] = [
                    'name' => $value['name'],
                    'Quantity' => $quantity,
                    'Total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
                ];
            }
        }
        return $departmentTotal;
    }


    public static function OrderTotal($orderList)
    {

        $price = 0;
        $totalCostPrice = 0;
        
        foreach ($orderList as $receiptList) {
            $totalCostPrice = Stock::ReceiptTotal($receiptList, $totalCostPrice);
        }

        return $totalCostPrice;
    }


    public static function ReceiptTotal($receiptList, $totalCostPrice)
    {

        $price = $receiptList->receipt_stock_cost;

        if ($receiptList->receipt_discount) {

            foreach (json_decode($receiptList->receipt_discount) as $keyOverride => $valueDiscount) {


                if (Receipt::ReceiptCostOverrideType()[$valueDiscount->type] == 'percentage') {
                    //percentage at checkout
                    $price = MathHelper::Discount($valueDiscount->value, $receiptList->receipt_stock_cost);
                    
                } 
                elseif(Receipt::ReceiptCostOverrideType()[$valueDiscount->type] == 'amount') {
                    //minus the amount at checkout
                    $price = $price - $valueDiscount->value;
                }
            }
            
        }
       
        $price = $price * $receiptList->receipt_quantity;
        $totalCostPrice = $totalCostPrice + $price;

        return $totalCostPrice;
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

        return $totalCostPrice;

    }

    


    public static function StockVAT($stock){
    
        $userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        $settingModel = Setting::where('setting_store_id', $userModel->store_id)->first();
        
        if ($stock->stock_merchandise['stock_vat_id']) {
            $stock_vat = $settingModel->setting_vat[$stock->stock_merchandise['stock_vat_id']];
            return  $stock_vat['rate'];
        }

    }

   
    public static function StockCostDefault($stock_cost){
    
        $price = $stock_cost[1][1]['price'];

       //find discount-show on till button and checkout
       //mix and match-check out only
       //see variance to stock
       return $price;
       
    }

    public static function StockCostCustomer($stock_cost){
    
        $price = 0;

         //get customer id from session
        if (Session::has('user-session-'.Auth::user()->user_id.'.'.'customerCartList')) {
            $person_id = Session::get('user-session-'.Auth::user()->user_id.'.'.'customerCartList')[0]['value'];
            $pesonModel = Person::find($person_id);

            if ($pesonModel->person_stock_cost) {
                $price = $stock_cost[ $pesonModel->person_stock_cost[1]['column'] ][ $pesonModel->person_stock_cost[1]['row'] ]['price'];
            }
       } 

       //find discount-show on till button and checkout
       //mix and match-check out only
       //see variance to stock
       return $price;
       
    }
    

    //compare current
    public static function StockCurrentOffer($stock, $offerType){
        
        $stockOffer = [];
        

        if ($stock->stock_merchandise['stock_offer_id']) {

            $userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

            $settingModel = Setting::where('setting_store_id', $userModel->store_id)->first();

            $setting_stock_offer = collect($settingModel->setting_stock_offer)->only( $stock->stock_merchandise['stock_offer_id'] );

            //filter offer by date 
            foreach ($setting_stock_offer as $stock_offer_key => $stock_offer_value) {
                if ( $stock_offer_value['date']['start_date'] >= Carbon::now() && $offerType == $stock_offer_value['boolean']['type']) {
                    
                    $a = Carbon::now()->dayOfWeek;
                    //discount days
                    if (array_search( Carbon::now()->dayOfWeek, $stock_offer_value['available_day'] )) {
                        $stockOffer[$stock_offer_key] = $stock_offer_value;
                    }
                }
            }
        }

        return $stockOffer;
    }


    public static function StockCurrentOfferType($totalPrice, $stockCurrentOffer, $price){


        
        $stockCurrentOfferType = 0;
        $total = [];

        foreach ($stockCurrentOffer as $stockCurrentOfferKey => $stockCurrentOfferValue) {
            
            if (Setting::SettingDiscountType()[$stockCurrentOfferValue['decimal']['discount_type']] == 'percentage') {

                $stockCurrentOfferType = ['price'  => MathHelper::Discount($stockCurrentOfferValue['decimal']['discount_value'], $price)];
               
            } else {
                $stockCurrentOfferType = ['price' => $price - $stockCurrentOfferValue['decimal']['discount_value'] ];
               
            }

            if (count($stockCurrentOfferType) > 0) {
                $total[$stockCurrentOfferKey] = $stockCurrentOfferValue;
                $total[$stockCurrentOfferKey] += ['total' => $stockCurrentOfferType];
            }

        }
      
        //collect($stockCurrentOfferType)->min('price')
        
        

        return $total;
    }

    public static function StockCostMin($stockCurrentOfferType){
       return collect( $stockCurrentOfferType )->pluck('total')->min('price');
    }

    public static function Offer(){
        return [
            "Discount %",
            "Set Price",
            "Discount amount cheapest",
            "Discount % cheapest",
            "Discount amount last item",
            "Discount % last item"
        ];
    }


}
