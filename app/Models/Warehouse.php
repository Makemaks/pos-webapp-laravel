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
        }'
    ];

    protected $casts = [
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
        ->where($column,  $filter);
    }

    public static function Available($id){
        $stockList = Warehouse::where('warehouse_stock_id', $id )
        ->where('warehouse_quantity','>', 0)
        ->get();

        return $stockList;
    }

    public static function WarehouseStatus(){
        return [
            
        ];
    }

    public static function WarehouseCostType(){
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
            'wastage',
            'take',
            'variance'
        ];
    }
}
