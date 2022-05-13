<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouse';
    protected $primaryKey = 'warehouse_id';

    

    public static function List($column,  $filter){
        return Warehouse::
        leftJoin('stock', 'stock.stock_id', '=', 'warehouse.warehouse_stock_id')
        ->where($column,  $filter);
    }

    public static function Status(){
        return [];
    }

    public static function Type(){
        return [
            'return',
            'delivery',
            'transfer'
        ];
    }
}
