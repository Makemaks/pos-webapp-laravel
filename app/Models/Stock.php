<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            "group_id" :"",
            "category_id":"",
            "brand_id":"",

            "random_code": "",
            "expiration_date": "",
            "alert_level:""

            "non_stock": "",
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
            "stock_offer": ""
            
        }',

       
        "stock_terminal_flag" => '{
            "status_flag": {},
            "stock_control": {},
            "commission_rates": {},
            "kitchen_printers": {},
            "selective_itemisers": {}
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
        'stock_nutrition' => '{}',
       
       
        
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
        
    public static function List($column,  $filter){
        return Stock::
        leftJoin('account', 'account.account_id', '=', 'stock.stock_store_id')
        ->where($column,  $filter)
        ->orderBy('stock.created_at', 'desc');
    }

    
    public static function StockDefault(){

        
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

       for ($i=0; $i < count($stockCollection); $i++) { 
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

    public static function OfferType(){
       return [
           'voucher',
           'mix & match'
       ];
    }

   
    
}
