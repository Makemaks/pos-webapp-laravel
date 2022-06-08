<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Helpers\MathHelper;

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
            "recipe_link" => "",
            "case_size" => "",
            "plu_id": "",
            
            "current_stock": "",
            "days_to_order": "",
            "maximum_stock": "",
            "minimum_stock": "",
            "outer_barcode": "",
            "qty_adjustment": "",
            
            "stock_vat": "",
            "stock_name": "",
            "stock_description": "",
            "stock_quantity": "",
            "stock_image": "",
            "stock_tag": "",
            "stock_offer": "",
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

    public static function List()
    {

        return Stock::leftJoin('store', 'store.store_id', '=', 'stock.stock_store_id');
    }


    public static function StockDefault()
    {


        $stockCollection = [
            [
                'Crop Top And Short Set',
                '33',
                'Crop Top And Short Set.png'
            ],
            [
                'Eloquent Acro Progress Map',
                '4',
                'Eloquent Acro Progress Map.png'
            ],
            [
                'Eloquent All Black Stripes Tracksuit',
                '59',
                'Eloquent All Black Stripes Tracksuit.png'
            ],
            [
                'Eloquent Design Face Mask',
                '7',
                'Eloquent Design Face Mask.png'
            ],
            [
                'Eloquent Hold All Bag',
                '29',
                'Eloquent Hold All Bag.png'
            ],
            [
                'Eloquent Leotard',
                '25',
                'Eloquent Leotard.png'
            ],
            [
                'Eloquent Red T-Shirt',
                '22',
                'Eloquent Red T-Shirt.png'
            ],
            [
                'Face Mask Black Lives Still Matter',
                '25',
                'Face Mask Black Lives Still Matter.png'
            ]
        ];

        for ($i = 0; $i < count($stockCollection); $i++) {
            $stock = new stock;
            $stock->stock_name = $stockCollection[$i][0];


            $stock->stock_selling_price = [$stockCollection[$i][1]];
            $stock->stock_cost = [''];
            $stock->stock_quantity = [''];
            $stock->stock_supplier_id = [''];
            $stock->stock_image = $stockCollection[$i][2];

            $stockList[] = $stock;
        }



        return $stockList;
    }

    public static function OfferType()
    {
        return [
            'voucher',
            'mix & match'
        ];
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

                            $price = json_decode($orderList->stock_cost, true)[1][1]['price'];

                            $totalCostPrice = $totalCostPrice + $price * $orderList->receipt_quantity;

                            $quantity = $quantity + $orderList->receipt_quantity;
                           
                        }
                   
                }


                $departmentTotal[] = [
                    'description' => $value['description'],
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
            $totalCostPrice = $totalCostPrice + Stock::ReceiptTotal($receiptList);
        }

        return $totalCostPrice;
    }


    public static function ReceiptTotal($receiptList)
    {

        $price = 0;
        $totalCostPrice = 0;

        if ($receiptList->receipt_stock_cost) {
            foreach (json_decode($receiptList->receipt_stock_cost) as $key => $value) {
                $price = json_decode($receiptList->stock_cost, true)[$key][$value]['price'];
            }
        }
        
        

        if ($receiptList->receipt_stock_cost_override) {

            foreach (json_decode($receiptList->receipt_stock_cost_override) as $keyOverride => $valueOverride) {


                if (Receipt::ReceiptCostOverrideType()[$valueOverride->type] == 'percentage') {
                    //percentage at checkout
                    $price = $price - $valueOverride->value;
                    
                } 
                elseif(Receipt::ReceiptCostOverrideType()[$valueOverride->type] == 'amount') {
                    //minus the amount at checkout
                    $price = $price - $valueOverride->value;
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

    public static function StockCostDefault($stock_cost){
    
        return $stock_cost[1][1]['price'];

    }


}
