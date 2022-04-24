<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expense';
    protected $primaryKey = 'expense_id';

    public static function List($column,  $filter){
        return Expense::
        leftJoin('user', 'user.user_id', '=', 'expense.expense_user_id')
        ->where($column,  $filter)
        ->orderBy('expense.created_at', 'desc');
    }

    public static function User(){
        return Expense::
        leftJoin('user', 'user.user_id', '=', 'expense.expense_user_id')
        ->orderBy('expense.created_at', 'desc');
    }
}
