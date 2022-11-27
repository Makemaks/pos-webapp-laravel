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
        'warehouse_stock_price' => '{
            "1" : {
                "name": "",
                "description": "",
                "price": "",
                "schedule_datetime": "",
                "setting_stock_price_group_id" : ""
            }
        }',
        'warehouse_stock_price_quantity' => '{
            "1": "{
                "warehouse_stock_price_id" = "",
                "warehouse_stock_price_quantity" = ""
            }"
        }',
    ];

    protected $casts = [
        "warehouse_reason" => 'array',
        "warehouse_stock_price" => 'array',
        "warehouse_stock_price_quantity" => 'array',
    ];

    public static function Store(){
        return Warehouse::
        leftJoin('stock', 'stock.stock_id', '=', 'warehouse.warehouse_stock_id')
        ->leftJoin('store', 'store.store_id', '=', 'warehouse.warehouse_store_id');
    }

    public static function List($column,  $filter){
        return Warehouse::
        leftJoin('stock', 'stock.stock_id', '=', 'warehouse.warehouse_stock_id')
        ->where($column,  $filter);
    }

    public static function Available($id, $store_id = null){
       
        if ($store_id) {
            $stockList = Warehouse::where('warehouse_stock_id', $id )
            ->where('warehouse_quantity','>', 0)
            ->where('warehouse_store_id', $store_id)
            ->get();
        } else {
            $stockList = Warehouse::where('warehouse_stock_id', $id )
            ->where('warehouse_quantity','>', 0)
            ->get();
           
        }
        

        return $stockList;
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
