<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouse';
    protected $primaryKey = 'warehouse_id';
    protected $guarded = [''];
    

    public $timestamps = true;

    protected $attributes = [
        'warehouse_reason' => '{
            "type": "", 
            "description": ""
        }',
        'warehouse_inventory' => '{
            "current_stock": "",
            "frozen_stock": "",
            "setting_stock_case_size_id": "",
            "case_quantity": "",
            "item_quantity": "",
            "unit_size": ""
        }',
    ];

    protected $casts = [
        "warehouse_reason" => 'array',
        "warehouse_inventory" => 'array',
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
            'hold',
            'processing'
        ];
    }

    public static function WarehouseCostType(){
        return [
            'FIFO',
            'Avg Cost Price',
        ];
    }

    public static function WarehouseType(){
        return [
            'return',
            'delivery',
            'transfer',
            'wastage',
            'variance',
            'inventory'
        ];
    }
}
