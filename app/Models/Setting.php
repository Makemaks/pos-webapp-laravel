<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;
use App\Helpers\KeyHelper;
use App\Models\Expertise;
use App\Models\User;

use App\Helpers\MathHelper;

use App\Helpers\CurrencyHelper;
use Carbon\Carbon;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting';
    protected $primaryKey = 'setting_id';

    //creates default value
    public $timestamps = true;

    protected $attributes = [

      

        'setting_stock_set' => '{
            "1": {
                "name": "",
                "code": "",
                "type": ""
            }
        }',

        'setting_stock_label' => '{

            "SHELF": {
                "CUSTOM TEMPLATES": {},
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
                "CUSTOM TEMPLATES": {},
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


        'setting_printer' => '{}',
        'setting_stock_tag_group' => '{}',

        'setting_preset_message' => '{}',

        'setting_message_notification_category' => '{}',


        'setting_reason' => '{
            "1": {
                "name": "",
                "setting_stock_set": ""
            }
        }',

        'setting_vat' => '{
            "1": {
                "name": "",
                "rate": "",
                "default": ""
            }
        }',

        /* 'setting_price_level_scheduler' => '{
            "1": {
                "time": "",
                "price_level": 
            }
        }', */


        'setting_expense_budget' => '{}',
        'setting_expense_type' => '{}',


        'setting_pos' => '{
            "name":"",
            "cash":"0",
            "credit":"0"
        }',


       'setting_receipt' => '{
            "1": {
                "default": 1,
                "sig strip": {
                    "1":"",
                    "2":"",
                    "3":"Employee / Manager RRsignature",
                    "4":".......................John"
                },
                "vat number": "VAT No: 787655678",
                "bottom message": {
                    "1":"Thank You For Your Custom",
                    "2":"See You Soon",
                    "3":"MERRY CHRISTMAS",
                    "4":"www.theepsomclub.com"
                },
                "receipt header": {
                    "1":"The TESTING CLUB",
                    "2":"Tel: 061 319SS66  VAT: GB3158927S",
                    "3":"41-43 Chruch Street",
                    "4":"Epsom KT17 4QW"
                },
                "report message": {
                    "1":"",
                    "2":"",
                    "3":"",
                    "4":""
                },
                "commercial message": {
                    "1":"The Club is Open 1000-2200 Daily",
                    "2":"",
                    "3":"",
                    "4":""
                }
            }
        }',


        "setting_stock_nutrition" => '{

            "1": {
                "name": "Energy",
                "value": "",
                "measurement": "kcal"
            },
            "2": {
                "name": "Fat",
                "value": "",
                "measurement": "g"
            },
            "3": {
                "name": "Saturate",
                "value": "",
                "measurement": "g"
            },
            "4": {
                "name": "Carbohydrate",
                "value": "",
                "measurement": "g"
            },
            "5": {
                "name": "Sugar",
                "value": "",
                "measurement": "g"
            },
            "6": {
                "name": "Protein",
                "value": "",
                "measurement": "g"
            },
            "7": {
                "name": "Salt",
                "value": "",
                "measurement": "g"
            },
            "8": {
                "name": "Portions",
                "value": "",
                "measurement": "g"
            }

        }',


        "setting_stock_allergen" => '{


                "1": "Celery",
                "2": "Cereals Containing Gluten",
                "3": "Crustaceans",
                "4": "Eggs",
                "5": "Fish",
                "6": "Lupin",
                "7": "Milk",
                "8": "Molluscs",
                "9": "Mustard",
                "10": "Tree Nuts",
                "11": "Peanuts",
                "12": "Sesame Seeds",
                "13": "Soyabeans",
                "14": "Sulphur Dioxide and Sulphites",
                "15": "Allergen 15",
                "16": "Allergen 16"


        }',

        'setting_offer' => '{
            "1": {

                "decimal": {
                    "gain_points": "",
                    "collect_points_value": "",
                    "discount_type": "",
                    "discount_value": ""
                },
                "date": {
                    "end_date": "",
                    "start_date": ""
                },

                "integer": {
                    "set_menu":"",
                    "quantity":"",
                    "stock_price":"",
                    "priority":""
                },

                "boolean": {
                    "type":"",
                    "status":"",
                    "prompt":""
                },

                "string": {
                    "name":"",
                    "description":"",
                    "code":"",
                    "barcode":""
                },
                "available_day":{},
                "usage": {
                    "per_person": "",
                    "per_usage": ""
                }

            }
        }',

        'setting_stock_set_menu' => '{}',

        'setting_stock_recipe' => '{
            "1": {
                "link": null,
                "name": "illo",
                "default": 1
            }
        }',

        'setting_stock_case_size' => '{
            "1": {
                "size": "",
                "default": "",
                "description": ""
            }
        }',

        "setting_stock_tag" => '{
            "1": {
                "tag": "",
                "name": "",
                "setting_stock_tag_group_id": ""
            }
        }',

        "setting_api" => '{
            "1": {
                "name": "",
                "type": "",
                "key": "",
                "value": ""
            }
        }',

        'setting_key' => '{
            "1": {
                "setting_key_group": "",
                "setting_key_type": "",
                "name": "",
                "status": "",
                "description": "",
                "value": "",
                "image": "",
            }
        }',

        'setting_group' => '{
            "default_country": "",
            "default_currency": {},
            "logo": {},
            
        }',

        'setting_credit' => '{
            "customer_stock_price": "",
            "customer_credit": "",
            "customer_print": {},
            "customer_marketing": {}
        }',
        
        'setting_stock_price_level' => '{
            "1": {
                "name": "",
                "description": "",
            }
        }',

        'setting_building' => '{}'
    ];

    protected $casts = [

        'setting_stock_set' => 'array',
        'setting_stock_price_level' => 'array',
        'setting_stock_set' => 'array',

        'setting_stock_label'  => 'array',


        'setting_printer' => 'array',
        'setting_stock_tag_group' => 'array',

        'setting_message_notification_category' => 'array',
        //'setting_message_group' => 'array',


        'setting_reason' => 'array',
        'setting_vat' => 'array',


        'setting_expense_budget' => 'array',
        'setting_expense_type' => 'array',

        'setting_pos' => 'array',

        'setting_receipt' => 'array',


        'setting_stock_allergen' => 'array',
        'setting_stock_nutrition' => 'array',
        'setting_offer' => 'array',
        "setting_stock_set_menu" => 'array',

        "setting_stock_recipe" => 'array',
        "setting_stock_case_size" => 'array',

        "setting_stock_tag" => 'array',

        "setting_api" => 'array',

        'setting_key' => 'array',
       
        'setting_group' => 'array',
        'setting_credit' => 'array',
        'setting_preset_message' => 'array',
        'setting_building' => 'array',
        /* 'setting_price_level_scheduler' => 'array' */
        'setting_building' => 'array',
    ];

    public static function Account(){
        return Setting::
        rightJoin('account', 'account.account_id', 'setting.setting_account_id');
    }


    public static function List($column, $filter)
    {
        return Setting::leftJoin('store', 'store.store_id', '=', 'setting.setting_account_id');
    }


    public static function SettingOfferStatus()
    {
        return [
            'Enabled',
            'Disabled'
        ];
    }

    public static function SettingSettingOfferType()
    {
        return [
            "percentage",
            "amount",
        ];
    }

    public static function SettingExpertise()
    {


        foreach (Expertise::ExpertiseType() as $expertise) {
            $settingExpertiseList[] = [
                'expertise_name' => $expertise,
                'expertise_image' => NULL,
                'expertise_video' => NULL
            ];
        }

        return $settingExpertiseList;
    }

    public static function SettingAPI(){
        return [
            'system',
            'payment'
        ];
    }

    public static function SettingPaymentGateway()
    {
        return [
            'stripe',
            'apple',
            'paypal'
        ];
    }

    public static function SettingEventLoactaion()
    {
        return [
            'event_location_name',
            'event_room',
            'event_address_id',
        ];
    }

    public static function SettingStockSet(){

        return [
            "department",
            "group",
            "brand",
            "plu"
        ];
    }

    public static function SettingReason(){
        return [
            "Delivery",
            "Wastage",
            "Adjustment",
            "Transfer In",
            "Transfer Out",
            "Other",
        ];
    }

    public static function SettingOfferType(){
        return [
            'voucher', //coupons
            'discount', //one offs
            'multi-buy',
            'mix-match',
            'gift-card'
        ];
    }

    public static function SettingKeyGroup(){
        //see key helper in helpers
        return [
            'finalise',
            'status',
            'transaction',
            'character',
            'totaliser',
            'menu'
        ];
    }

    //session and grand total
    public static function SettingKey($data, $setting_key_list){

        $count = 0;

        if (count( $setting_key_list ) > 0) {
            
            foreach ( $setting_key_list as $key => $value) {

                //$value = head($value);
                $a = count(KeyHelper::Type()[ $value['setting_key_group'] ]);

                if (!array_key_exists(  $value['setting_key_type'], KeyHelper::Type()[ $value['setting_key_group'] ] ) ) {
                    $a = 0;
                }
                $setting_key_type = KeyHelper::Type()[ $value['setting_key_group'] ][ $value['setting_key_type'] ];

                /*  
                $setting_key_value = collect($settingModel->setting_key)->where('setting_key_group', $value['setting_key_group'] )
                ->where('setting_key_type', $value['setting_key_type'] )
                ->first()['value']; */
                if ( Str::contains( $setting_key_type, '%') || Str::contains( $setting_key_type, '+') || Str::contains( $setting_key_type, '-')) {

                    if($count == 0){
                       $data['setupList']['setting_key_amount_total'] = $value['value'];
                    }
                    else{

                        if( Str::contains( $setting_key_type, '%') && $value['value'] ){
                            $setting_key_amount = MathHelper::VAT($value['value'], $data['setupList']['stock_price_processed']);
                            $value['value'] =  $setting_key_amount;
                        }
                        
                        if ( Str::contains($setting_key_type, '+' ) ) {
                            $data['setupList']['setting_key_amount_total'] = $data['setupList']['setting_key_amount_total'] + $value['value'];
                            $data['setupList']['stock_price_processed'] = $data['setupList']['stock_price_processed'] + $value['value'];
                        }
                        elseif( Str::contains( $setting_key_type, '-' ) ){
                            $data['setupList']['setting_key_amount_total'] = $data['setupList']['setting_key_amount_total'] + $value['value'];
                            $data['setupList']['stock_price_processed'] = $data['setupList']['stock_price_processed'] + $value['value'];
                        }

                    }

                }
                
                $count++;
                
            }


        }
       
        
        return $data;

    }


    //stock
    public static function SettingOffer($stockInitialize, $data){

        $settingCurrentSettingOfferType = [];
        $total = [];
        $price = $data['setupList']['stock_price'];
        $stockOffer = [];

        $userModel = User::Account('account_id', Auth::user()->user_account_id)
        ->first();

        $settingModel = Setting::where('setting_account_id', $userModel->store_id)->first();

        foreach ($stockInitialize['stock_setting_offer']  as $key => $setting_offer_id) {
            $stock_setting_offer = $settingModel->setting_offer[ $setting_offer_id ];

                if ($stock_setting_offer['date']['end_date'] > Carbon::now() &&
                array_search( Carbon::now()->dayOfWeek, $stock_setting_offer['available_day']) ) {

                    //discount
                    if ( Setting::SettingOfferType()[$stock_setting_offer['boolean']['type']] == 'voucher' ) {

                        if (Setting::SettingSettingOfferType()[$stock_setting_offer['decimal']['discount_type']] == 'percentage') {

                            $settingCurrentSettingOfferType[] = ['discount_value'  => MathHelper::Discount($stock_setting_offer['decimal']['discount_value'], $price) ];
            
                        } else {
                            $settingCurrentSettingOfferType[] = ['discount_value' => $stock_setting_offer['decimal']['discount_value'] ];
                        }

                    }
                    elseif( Setting::SettingOfferType()[$stock_setting_offer['boolean']['type']] == 'discount' ){

                        if (Setting::SettingSettingOfferType()[$stock_setting_offer['decimal']['discount_type']] == 'percentage') {

                            $settingCurrentSettingOfferType[] = ['discount_value'  => MathHelper::Discount($stock_setting_offer['decimal']['discount_value'], $price) ];
            
                        } else {
                            $settingCurrentSettingOfferType[] = ['discount_value' => $stock_setting_offer['decimal']['discount_value'] ];
                        }
                    }
                    elseif( Setting::SettingOfferType()[$stock_setting_offer['boolean']['type']] == 'multi-buy' ){

                        if (Setting::SettingSettingOfferType()[$stock_setting_offer['decimal']['discount_type']] == 'percentage') {

                            $settingCurrentSettingOfferType[] = ['discount_value'  => MathHelper::Discount($stock_setting_offer['decimal']['discount_value'], $price) ];
            
                        } else {
                            $settingCurrentSettingOfferType[] = ['discount_value' => $stock_setting_offer['decimal']['discount_value'] ];
                        }

                    }
                    
                    elseif( Setting::SettingOfferType()[$stock_setting_offer['boolean']['type']] == 'mix-match' ){
                        
                        if (Setting::SettingSettingOfferType()[$stock_setting_offer['decimal']['discount_type']] == 'percentage') {

                            $settingCurrentSettingOfferType[] = ['discount_value'  => MathHelper::Discount($stock_setting_offer['decimal']['discount_value'], $price) ];
            
                        } else {
                            $settingCurrentSettingOfferType[] = ['discount_value' => $stock_setting_offer['decimal']['discount_value'] ];
                        }
                    }

                    $stockOffer[$key] = $stock_setting_offer;
                }
           
        }

        
       
        $data['setupList']['stock_setting_offer'] = $stockOffer;
        $data['setupList']['stock_setting_offer_total'] = collect($settingCurrentSettingOfferType)->sum('discount_value');
        $data['setupList']['stock_price_processed'] = $data['setupList']['stock_price'] - $data['setupList']['stock_setting_offer_total'];
        return $data;

    }

    
    public static function SettingCurrency($data){
        $currencySymbol = '£';

        $setting_default_currency =  collect($data['settingModel']->setting_group['default_currency'])
        ->where('default', 0)
        ->first();

        if ($setting_default_currency) {
            $currency = CountryHelper::ISO()[$setting_default_currency->currency_id]['currencies'][0];
            $currencySymbol = CountryHelper::CurrencySymbol()[$currency];
        }
    
        return $currencySymbol;
    }


    public static function SettingKeyProcessed($data, $data_array_key_A, $data_array_key_B){
        $setting_key = collect( $data['settingModel']->setting_key )->where('setting_key_group', 0)
        ->where('setting_key_type', 0)->toArray();

        $setting_key['value'] = $data['setupList'][$data_array_key_A];

        if ( count( $data['setupList'][$data_array_key_B] ) > 0) {
            $data['setupList'][$data_array_key_B] += $setting_key;
        } else {
            $data['setupList'][$data_array_key_B][1] = $setting_key;
        }

        return $data;
    }


}
