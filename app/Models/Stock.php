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
    public $timestamps = true;

    protected $attributes = [

       

        'stock_store_id' => 1,
        "stock_price" => '{
            "1": {
                "name": "",
                "description": "",
                "price": "",
                "schedule_datetime": "",
                "setting_stock_price_group_id" : ""
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
            "plu_id": {},
            
            "alternative_text": "",
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
            "setting_offer_id": {},
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
        'stock_price_quantity' => '{
            "1": "{
                "stock_price_id" = "",
                "warehouse_stock_price_quantity" = "",
            }"
        }',

        'stock_manager_special' => '{
            "1": {
                "1": ""
            }
        }'


    ];


    protected $casts = [
        'stock_price' => 'array',
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
        leftJoin('store', 'store.store_id', '=', 'stock.stock_store_id')
        ->leftJoin('warehouse', 'warehouse.warehouse_stock_id', '=', 'stock.stock_id')
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

                foreach ($data['orderList'] as $orderList) {

                    $stock_merchandise = json_decode($orderList->stock_merchandise, true);

                
                    if ($orderList->receipt_id != null) {

                        if ($stock_merchandise[$stock_merchandise_key] == $key) {

                            $price = $orderList->receipt_stock_price;

                            $totalPrice = $totalPrice + $price * $orderList->receipt_quantity;

                            $quantity = $quantity + $orderList->receipt_quantity;
                            
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

            $price = Stock::Discount($stock_price, $receiptList->receipt_discount);
        }
       
        $price = $price * $receiptList->receipt_quantity;
        $totalPrice = $totalPrice + $price;

        return $totalPrice;
    }

    public static function Discount($stock_price, $discount){

        $price = 0;

        foreach (json_decode($discount) as $keyOverride => $valueDiscount) {

            if (Receipt::ReceiptPriceOverrideType()[ $valueDiscount->type ] == 'percentage') {
                //percentage at checkout
                $price = $price + MathHelper::Discount($discount_value, $stock_price);
                
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

    


    public static function StockVAT($stock){
    
        $userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        $settingModel = Setting::where('settingtable_id', $userModel->store_id)->first();
        
        if ($stock->stock_merchandise['stock_vat_id']) {
            $stock_vat = $settingModel->setting_vat[$stock->stock_merchandise['stock_vat_id']];
            return  $stock_vat['rate'];
        }

    }

   
    public static function StockPriceDefault($stock_price){
    
        $price = $stock_price[1]['price'];

       //find discount-show on till button and checkout
       //mix and match-check out only
       //see variance to stock
       return $price;
       
    }

    public static function StockPriceCustomer($stock_price){
    
        $price = 0;

         //get customer id from session
        if (Session::has('user-session-'.Auth::user()->user_id.'.'.'customerCartList')) {
            $customer = Session::get('user-session-'.Auth::user()->user_id.'.'.'customerCartList')[0]['value'];
        

          
                $personModel = Person::find($customer);
                $companyModel = Company::find($personModel->persontable_id);

                if ($companyModel) {
                    $settingModel = Setting::SettingTable()
                    ->where('setting.settingtable_id', $companyModel->person_id)
                    ->first();
                }
                elseif ($personModel) {
                    $settingModel = Setting::SettingTable()
                    ->where('setting.settingtable_id', $personModel->person_id)
                    ->first();
                }
                
                

                foreach ($settingModel->setting_customer['customer_stock_price'] as $key => $value) {
                    //column row
                    $price = $stock_price[ $key ][ $value ]['price'];
                }
       } 

       //find discount-show on till button and checkout
       //mix and match-check out only
       //see variance to stock
       return $price;
       
    }
    

    public static function StockPriceQuantity($stock_price, $stock_quantity){
        return $stock_price * intval($stock_quantity);
    }

    //find the minum offer price
    public static function StockPriceMin($settingCurrentOfferType){
        $min = collect( $settingCurrentOfferType )->pluck('total')->min('price');
        return collect( $settingCurrentOfferType )->where('total.price',  $min)->first();
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

    public static function OfferStatus()
    {
        return [
            'Enabled',
            'Disabled'
        ];
    }


}
