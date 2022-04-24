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
        
        'setting_logo' => '{}',
        
       
        'setting_stock_group_category_plu' => '{
            "1": {
                "descriptor": "",
                "code": "",
                "type": ""
            }
        }',

        'setting_stock_label' => '{
           
            "SHELF": {
                "CUSTOM TEMPLATES": [],
                "DEFAULT TEMPLATES": {
                    "A4": "A4 (24 labels [3x8], 60x30mm) - 210mm x 297mm",
                    "GK420t": "GK420t (Single label feed, 48.5 x 35mm) - 49mm x 35mm",
                    "A4 SPAR": "A4 SPAR (24 labels [3x8], 67.5x34mm) - 210mm x 297mm",
                    "DK-1201": "DK-1201 (Single label roll, 90 x 29mm) - 90mm x 29mm",
                    "EU30016WX": "EU30016WX (24 labels [3x8], 63.5 x 33.9mm) - 210mm x 297mm",
                    "SECC21LCE": "SECC21LCE (21 labels [3x7], 70 x 37.5mm) - 210mm x 297mm",
                    "DA402 80x38": "DA402 80x38 (ZEBRA Single label roll, 80 x 38mm) - 80mm x 38mm",
                    "A4 (Allergens)": "A4 (Allergens) (8 labels [1x8], 120x30mm) - 210mm x 297mm",
                    "SRP-770II 38x25": "SRP-770II 38x25 (BIXILON Single label roll, 38 x 25mm) - 38mm x 25mm",
                    "SRP-770II 45x35": "SRP-770II 45x35 (BIXILON Single label roll, 45 x 35mm) - 45mm x 35mm",
                    "A4 (Alternative Text)": "A4 (Alternative Text) (24 labels [3x8], 60x30mm) - 210mm x 297mm"
                }
            },
            "STOCK": {
                "CUSTOM TEMPLATES": [],
                "DEFAULT TEMPLATES": {
                    "DK-1201": "DK-1201 - 90mm x 29mm",
                    "SLP-MRL": "SLP-MRL - 51mm x 28mm",
                    "DK-11204": "DK-11204 - 54mm x 17mm",
                    "DK-22210": "DK-22210 - 100mm x 29mm",
                    "SRP-770II 38x25": "SRP-770II 38x25 - 38mm x 25mm",
                    "SRP-770II 45x35": "SRP-770II 45x35 - 45mm x 35mm",
                    "DK-1201 (Allergens)": "DK-1201 (Allergens) - 90mm x 29mm",
                    "DK-1201 (Alternative Text)": "DK-1201 (Alternative Text) - 90mm x 29mm"
                }
            }
       
        }',

        'setting_stock_voucher' => '{
            "1": {
                "number": "",
                "store_id": "",
                "name": "",
                "value": "",
                "expiry_date": "",
                "status": "",
                "type": "",
                "quantity": "",
            }
        }',

        'setting_printer' => '{}',
        'setting_stock_tag_group' => '{}',
        
        'setting_message_notification_category' => '{}',
        
        
        'setting_reason' => '{
            "1": {
                "name": "",
                "setting_stock_group_category_plu_id": ""
            }
        }',

        'setting_vat' => '{
            "1": {
                "name": "",
                "rate": "",
                "active": ""
            }
        }',

        
        'setting_expense_budget' => '{}',
        'setting_expense_type' => '{}',

       
        'setting_pos' => '{"name":"","cash":"0","credit":"0"}',
        

        'setting_receipt' => '{
            "1": {
                "receipt header": {},
                "commercial message": {},
                "bottom message": {},
                "report message": {},
                "sig strip": {},
                "vat number": {},
                "default" : {}
            }
            
        }',

        'setting_payment_gateway' => '{}', 

        'setting_keys' => '{}', 
        'setting_mix_match' => '{}', 
    ];

    protected $casts = [

        'setting_logo' => 'array',
        'setting_keys' => 'array',
       
        'setting_stock_group_category_plu' => 'array',
        
        'setting_stock_label'  => 'array',
        'setting_stock_voucher'  => 'array',
        
        'setting_printer' => 'array',
        'setting_stock_tag_group' => 'array',

        'setting_message_notification_category' => 'array',
        'setting_message_group' => 'array',

       
        'setting_reason' => 'array',
        'setting_vat' => 'array',

        
        'setting_expense_budget' => 'array',
        'setting_expense_type' => 'array',
        
        'setting_pos' => 'array',
        

        'setting_receipt' => 'array',

        'setting_payment_gateway' => 'array',

        'setting_mix_match' => 'array'
        
       
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
