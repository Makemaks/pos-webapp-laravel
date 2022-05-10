<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';
    protected $primaryKey = 'person_id';

    protected $attributes = [
        'person_name' => '{
            "person_lastname": "",
            "person_firstname": "",
            "person_preferred_name": ""

        }',
        'person_phone' => '{}',
        'person_email' => '{}',
        'person_message_notification' => '{}',
        
        'person_message_group' => '{}'
    ];

    protected $casts = [
        'person_name' => 'array',
        'person_phone' => 'array',
        'person_email' => 'array',
       
        'person_message_notification' => 'array',
        'person_message_group' => 'array'
    ];
    
   

    public static function Store($column, $filter){
        return Person::
        leftJoin('user', 'user.user_person_id', '=', 'person.person_id')
        ->leftJoin('store', 'store.store_id', 'person.persontable_id')
        ->where($column, $filter);
    }

    public static function Account(){
        return Person::
        leftJoin('account', 'account.accountable_id', 'person.person_id');
    }

    public static function Company(){
        return Person::
        leftJoin('company', 'company.company_id', 'person.person_company_id');
    }

    public static function List(){
        return Person::
        leftJoin('account', 'account.account_id', 'person.user_account_id');
    }

    public static function Address(){
        return Person::
        leftJoin('address', 'address.addresstable_id', 'person.person_id')
        ->where('addresstable_type', 'person');
    }

    public static function User(){
        return Person::
        leftJoin('user', 'user.user_person_id', 'person.person_id');
    }

    public static function Child(){
        return Person::
        leftJoin('user', 'user.user_id', '=', 'person.person_user_id');
    }


    public static function PersonType(){
        return [
            'Non-Employee',
            'Employee',
        ];
    }

    public static function PersonExpertise(){
      return [
          
      ];
    }

    public static function PersonCustodian(){
        return [
            'Father',
            'Mother',
            'Sibling',
            'Relative',
            'Other'
        ];
    }


    public static function PersonContact(){
        return [
            'contactable_id',
            'contactable_type',
        ];
    }
   
    public static function PersonMessage(){
        return [
            'messagetable_name' => ['messagetable_id','messagetable_type']
        ];
    }

    public static function PersonGroupList($person_group, $person_group_type = null){

        foreach ($person_group as $person) {
            if ($person_group_type) {
                if ($person_group_type == $person->$person_group_type) {
                    $person_id_list[] = $person->person_id;
                }
            } else {
                $person_id_list[] = $person->person_id;
            }
            
        }
       
        return $person_id_list;
   
    }
}
