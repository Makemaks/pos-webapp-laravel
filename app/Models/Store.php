<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Store extends Model
{
    use HasFactory;

    protected $table = 'store';
    protected $primaryKey = 'store_id';



    public static function List($column,  $filter)
    {
        return Store::join('company', 'company.company_id', 'store.store_company_id')
            ->where($column,  $filter)
            ->orderBy('store.store_name', 'desc');
    }

    public static function Sale($column,  $filter)
    {
        return Store::leftJoin('order', 'order.order_store_id', '=', 'store.store_id')
            ->leftJoin('user', 'user.user_id', '=', 'order.order_user_id')
            ->leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->where($column,  $filter)
            ->orderBy('order.created_at', 'desc');
    }

    public static function Setting($column,  $filter)
    {
        return Store::leftJoin('order', 'order.order_store_id', '=', 'store.store_id')
            ->leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('setting', 'setting.setting_store_id', '=', 'store.store_id')
            ->where($column,  $filter)
            ->orderBy('order.created_at', 'desc');
    }


    public static function Order($column,  $filter)
    {
        return Store::rightJoin('order', 'order.order_store_id', '=', 'store.store_id')
            ->leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('user', 'user.user_id', '=', 'order.order_user_id')
            ->leftJoin('person', 'person.person_id', '=', 'user.user_person_id')
            ->leftJoin('setting', 'setting.setting_store_id', '=', 'store.store_id')
            ->where($column,  $filter)
            ->orderBy('order.created_at', 'desc');
    }

    public static function Company($column,  $filter)
    {
        return Store::leftJoin('order', 'order.order_store_id', '=', 'store.store_id')
            ->leftjoin('company', 'company.company_id', '=', 'store.store_company_id')
            ->leftJoin('receipt', 'receipt.receipt_order_id', '=', 'order.order_id')
            ->leftJoin('stock', 'stock.stock_id', '=', 'receipt.receipttable_id')
            ->leftJoin('user', 'user.user_id', '=', 'order.order_user_id')
            ->leftJoin('person', 'person.person_id', '=', 'user.user_person_id')
            ->where($column,  $filter)
            ->orderBy('order.created_at', 'desc');
    }

    public static function Account($column,  $filter)
    {
        return Store::leftJoin('account', 'account.account_id', '=', 'store.store_account_id')
            ->leftJoin('company', 'company.company_id', '=', 'store.store_company_id')
            ->where($column,  $filter)
            ->orderBy('store.store_name', 'desc');
    }

    public static function Linked($column,  $filter)
    {
        return Store::leftJoin('account', 'account.account_id', '=', 'store.store_id')
            ->whereIn($column,  $filter)
            ->orderBy('store.store_name', 'desc');
    }


    public static function Root($column,  $filter)
    {
        return Store::leftJoin('account', 'account.account_id', '=', 'store.store_id')
            ->leftJoin('company', 'company.company_store_id', '=', 'store.store_id')
            ->whereNULL('root_store_id')
            ->where($column,  $filter)
            ->orderBy('store.store_name', 'desc');
    }

    public static function User($column,  $filter)
    {
        return Store::leftJoin('person', 'person.user_account_id', '=', 'store.store_id')
            ->leftJoin('user', 'user.user_person_id', '=', 'person.person_id')
            ->where($column,  $filter);
    }

    public static function Address($column,  $filter)
    {
        return Store::leftJoin('address', 'address.addresstable_id', '=', 'store.store_id')
            ->where('addresstable_type', 'store')
            ->where($column,  $filter);
    }
}
