<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Helpers\StringHelper;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    protected $primaryKey = 'address_id';

    protected $attributes = [
        'address_line' => '{}',
        'address_email' => '{}',
        'address_phone' => '{}',
        'address_website' => '{}',
        'address_geolocation' => '{}'

    ];
    protected $casts = [
        'address_line' => 'array',
        'address_email' => 'array',
        'address_phone' => 'array',
        'address_website' => 'array',
        'address_geolocation' => 'array'
    ];


    public static function List($column, $filter){
        return Address::
        rightJoin('person', 'person.person_id', 'address.addresstable_id')
        ->rightJoin('company', 'company.company_id', 'address.addresstable_id')
        ->where($column, $filter);
    }

    public static function Person($column, $filter){
        return Address::
        leftJoin('person', 'person.person_id', 'address.addresstable_id')
        ->where($column, $filter);
    }

    public static function Company($column, $filter){
        return Address::
        leftJoin('company', 'company.company_id', 'address.addresstable_id')
        ->where($column, $filter);
    }

    public static function Details($model){
        $format_address =  '';
        $format_phone =  '';
        $format_email = '';
        $format_website = '';

       if($model->address_line_1){
            $format_address = $model->address_line_1;
       }
       if($model->address_line_2){
            $format_address =  $format_address . StringHelper::StringSeparator() . $model->address_line_2;
       }
       if($model->address_line_3){
            $format_address =  $format_address . StringHelper::StringSeparator() . $model->address_line_3;
       }
       if($model->address_town){
            $format_address =  $format_address . StringHelper::StringSeparator() . $model->address_town;
       }
       if($model->address_county){
           $format_address =  $format_address . StringHelper::StringSeparator() . $model->address_county;
       }
       if($model->address_postcode){
            $format_address =  $format_address . StringHelper::StringSeparator() . $model->address_postcode;
       }
       if($model->address_country){
            $format_address =  $format_address . ' . ' . $model->address_country;
       }

        if($model->address_phone_1){
            $format_phone = $model->address_phone_1;
        }
        if($model->address_phone_2){
            $format_phone =  $format_phone . StringHelper::StringSeparator() . $model->address_phone_2;
        }

        if($model->address_email_1){
            $format_email = $model->address_email_1;
        }
        if($model->address_email_2){
            $format_email =  $format_email . StringHelper::StringSeparator() . $model->address_email_2;
        }

        if($model->address_website_1){
            $format_website = $model->address_website_1;
        }
        if($model->address_website_2){
            $format_website =  $format_website . StringHelper::StringSeparator() . $model->address_website_2;
        }

        return [
            'address' => $format_address,
            'phone' => $format_phone,
            'email' => $format_email,
            'website' => $format_website
        ];
     }

  
}
