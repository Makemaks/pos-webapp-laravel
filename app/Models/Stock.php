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
                "price": "",
                "quantity": "",
                "default": 1,
                "supplier_id": ""
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
            "master_plu": "",
            
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

    public static function GroupCategoryBrandPlu($data, $type)
    {

        $totalCostPrice = 0;
        $price = 0;
        $departmentTotal = [];

        foreach ($data['settingModel']->setting_stock_group as $key => $value) {

         

            if ($value['type'] == $type) {
                $stockReceiptOrder = $data['orderList']->where('stock_merchandise->category_id', $key);


                $totalCostPrice =  Stock::OrderTotal($data['orderList']);

                $i = 0;

                foreach ($data['orderList'] as $orderList) {


                    $category_id = json_decode($orderList->stock_merchandise, true);

                    if ($category_id['category_id'] == $key && array_key_exists($key, json_decode($orderList->stock_cost, true))) {

                        $price = json_decode($orderList->stock_cost, true)[$key]['price'];
                        $totalCostPrice = $totalCostPrice + $price;

                        $i++;
                    }
                }


                $departmentTotal[] = [
                    'description' => $value['description'],
                    'Quantity' => $i,
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

       
        
        foreach ($orderList as $stockList) {

            if ($stockList->receipt_id == 500) {
                $a = $stockList->receipt_id;

            }

            if ($stockList->receipt_id) {
               
                if ($stockList->receipt_stock_cost_override) {
                    $price = $stockList->receipt_stock_cost_override * $stockList->receipt_quantity;
                } else {
                    $price = json_decode($stockList->stock_cost, true)[$stockList->receipt_stock_cost_id]['price'] * $stockList->receipt_quantity;
                }
               
            }

            $totalCostPrice = $totalCostPrice + $price;
        }

        return $totalCostPrice;
    }
}
