<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouse';
    protected $primaryKey = 'warehouse_id';

    

    public $timestamps = true;

    protected $attributes = [
        'warehouse_reason' => '{
            "type": "",
            "description": ""
        }',
        "warehouse_stock_price" => '{
            "1": {
                "price": "",
                "setting_stock_price_level": "",
                "setting_stock_price_group": "",
                "is_special_price" : ""
            }
        }',

        'warehouse_stock_price_quantity' => '{
            "1": {
                "stock_price_quantity": "",
                "setting_stock_price_group": ""
            }
        }',
     
    ];

    protected $casts = [
        'warehouse_stock_price' => 'array',
        'warehouse_stock_price_quantity' => 'array',
        "warehouse_reason" => 'array'
    ];

    public static function Store(){
        return Warehouse::
        leftJoin('stock', 'stock.stock_id', '=', 'warehouse.warehouse_stock_id')
        ->leftJoin('store', 'store.store_id', '=', 'warehouse.warehouse_store_id');
    }

    public static function List($column,  $filter){
        return Warehouse::
        leftJoin('stock', 'stock.stock_id', '=', 'warehouse.warehouse_stock_id')
        ->leftJoin('store', 'store.store_id', '=', 'warehouse.warehouse_store_id')
        ->where($column,  $filter);
    }

    

    public static function WarehouseStatus(){
        return [
            'FIFO',
            'Average Cost Price',
        ];
    }

    public static function WarehouseType(){
        return [
            'return',
            'delivery',
            'transfer',
            'wastage'
        ];
    }
}
