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
                "amount": "",
                "quantity": "",
                "default": ""
            }
        }',
        
        "stock_supplier" => '{
            "1": {
                "ref": "",
                "code": "",
                "unit cost": "",
                "case cost": ""
              
            }
        }',

        "stock_gross_profit" => '{
            "rrp": "",
            "actual": "",
            "target": "",
            "average cost": ""
        }',

        "stock_boolean" => '{}',

        "stock_tag" => '{}',

        "stock_recipe" => '{}',

        "stock_allergen" => '{}',

        "stock_print_exclusion" => '{}',

        "stock_offers" => '{
            "1": {
                "gain": "",
                "collect": "",
                "default": ""
            }
            
            
        }',

        "stock_merchandise" => '{
            "case size": "",
            "non stock": "",
            "unit size": "",
            "master pLU": "",
            "recipe link": "",
            "crrent stock": "",
            "days to order": "",
            "maximum stock": "",
            "minimum stock": "",
            "outer barcode": "",
            "qty adjustment": ""
        }',

       "stock_transfer" => '{
            "1": {
                "date": "",
                "type": "",
                "price": "",
                "user_id": "",
                "quantity": "",
                "stock_id": "",
                "store_id": ""
            }
        }',

        "stock_termminal_flags" => '{
            "Status Flags": {},
            "Stock Control": {},
            "Commission Rates": {},
            "Kitchen Printers": {},
            "Selective Itemisers": {}
        }',

        "stock_web" => '{
            "1": {
                "plu": "",
                "min": "",
                "max": "",
                "price": ""
            }
        }',

        "stock_nutrition" => '{}',

       
    ];

  
    

    protected $casts = [
        'stock_cost' => 'array',
        'stock_supplier' => 'array',
        'stock_gross_profit' => 'array',
        'stock_offers' => 'array',
        "stock_boolean" => 'array',
        "stock_tag" => 'array',
        "stock_recipe" => 'array',
        "stock_allergen" => 'array',
        "stock_print_exclusion" => 'array',
        "stock_merchandise" => 'array',
        "stock_transfer" => 'array',
        "stock_termminal_flags" => 'array',
        "stock_web" => 'array',
        "stock_nutrition" => 'array'
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
}
