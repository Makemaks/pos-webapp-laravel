<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $primaryKey = 'company_id';

    public static function Account(){
        return Company::
        leftJoin('account', 'account.accountable_id', 'company.company_id');
    }

    public static function Store(){
        return Company::
        leftJoin('store', 'store.store_id', 'company.company_store_id');
    }

    public static function Address(){
        return Company::
        leftJoin('store', 'store.store_id', 'company.company_store_id')
        ->leftJoin('address', 'address.addresstable_id', 'company.company_id')
        ->where('addresstable_type', 'company');
    }

    public static function Person(){
        return Company::
        leftJoin('person', 'person.person_company_id', 'company.company_id');
    }

  

   
    public static function CompanyType(){
        return [
            'Customer',
            'Supplier',
            'Contractor'
        ];
    }
   
}
