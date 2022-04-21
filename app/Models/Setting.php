<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Expertise;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting';
    protected $primaryKey = 'setting_id';

    //creates default value
    protected $attributes = [
        
        'setting_payment_gateway' => '{}',
        'setting_message_group' => '{}', 

        
        'setting_stock_type' => '{}',
        'setting_stock_category' => '{}',
        'setting_stock_group' => '{}',
        'setting_stock_plu' => '{}',
        'setting_stock_allergen' => '{}',
        'setting_stock_nutrition' => '{}',
        'setting_stock_rate' => '{}',
        
        'setting_message_notification_category' => '{}',
        
        'setting_printer' => '{}',

        'setting_country' => '{}',
        'setting_expense_budget' => '{}',
        'setting_expense_type' => '{}',
        'setting_store_vat' => '{}',
        'setting_pos' => '{"name":"","cash":"0","credit":"0"}',
        
    ];

    protected $casts = [
        'setting_payment_gateway' => 'array',
        'setting_message_group' => 'array',
     
        
        'setting_stock_type' => 'array',
        'setting_stock_category' => 'array',
        'setting_stock_group' => 'array',
        'setting_stock_plu' => 'array',
        'setting_stock_allergen' => 'array',
        'setting_stock_nutrition' => 'array',
        'setting_stock_rate' => 'array',
        
        'setting_printer' => 'array',

        'setting_message_notification_category' => 'array',
       
        'setting_country' => 'array',
        'setting_expense_type' => 'array',
        'setting_expense_budget' => 'array',
        'setting_store_vat' => 'array',
        'setting_pos' => 'array',
       
    ];

    public static function List($column, $filter){

        return Setting::
        leftJoin('store', 'store.store_id', '=', 'setting.setting_store_id');
       
    }

    public static function Account($column, $filter){

        $setting = Setting::
        where($column, $filter)
        ->first();

        if($setting){
            return $setting;
        }else{
            return new Setting();
        }
    }

    public static function SettingClass(){
        return [
            'Person',
            'stock',
            'Project',
            'Company',
        ];
    }

    public static function SettingExpertise(){
       

        foreach ( Expertise::ExpertiseType() as $expertise) {
            $settingExpertiseList[] = [
                'expertise_name' => $expertise,
                'expertise_image' => NULL,
                'expertise_video' => NULL
            ];
        }

        return $settingExpertiseList;
    }


    public static function SettingPaymentGateway(){
        return [
            'stripe',
            'apple',
            'paypal'
        ];
    }

    public static function SettingPaymentGatewayAPI(){
        return [
            ['name' => 'stripe', 'key' => '', 'secret' => ''],
        ];
    }

    public static function SettingEventLoactaion(){
        return [
            'event_location_name',
            'event_room',
            'event_address_id',
        ];
    }
}
