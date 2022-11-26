<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        // return Company::
        return DB::table('company as c1')
        ->leftJoin('store', 'store.store_id', 'c1.company_store_id')
        ->leftJoin('company as c2', 'c1.parent_company_id', 'c2.company_id')
        ->select('c1.company_id','c1.company_name','c1.company_type','c1.company_contact','c1.company_opening_hour','store.store_name','c2.company_name as parent_company')
        ->orderByDesc('c1.company_id');
    } 

    public static function Company(){
        return Company::selfJoin('company as c2', 'c2.parent_company_id', 'company.company_id');
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
