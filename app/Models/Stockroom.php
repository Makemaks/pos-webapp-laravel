<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stockroom extends Model
{
    use HasFactory;

    protected $table = 'stockroom';
    protected $primaryKey = 'stockroom_id';

    

    public static function List($column,  $filter){
        return Stockroom::
        leftJoin('stock', 'stock.stock_id', '=', 'stockroom.stockroom_stock_id')
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
