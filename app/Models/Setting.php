<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Str;

use App\Models\Expertise;
use App\Models\Setting;
use App\Models\User;

use App\Helpers\MathHelper;
use Carbon\Carbon;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting';
    protected $primaryKey = 'setting_id';

    //creates default value
    public $timestamps = true;

    protected $attributes = [

        'setting_logo' => '{}',
        
       
        'setting_stock_group' => '{
            "1": {
                "name": "",
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


        'setting_printer' => '{}',
        'setting_stock_tag_group' => '{}',

        'setting_preset_message' => '{}',

        'setting_message_notification_category' => '{}',


        'setting_reason' => '{
            "1": {
                "name": "",
                "setting_stock_group": ""
            }
        }',

        'setting_vat' => '{
            "1": {
                "name": "",
                "rate": "",
                "default": ""
            }
        }',

        'setting_price_level_scheduler' => '{
            "1": {
                "day": ,
                "time": "",
                "price_level": 
            }
        }',


        'setting_expense_budget' => '{}',
        'setting_expense_type' => '{}',


        'setting_pos' => '{"name":"","cash":"0","credit":"0"}',


        'setting_receipt' => '{
            "1": {
                "default": 1,
                "sig strip": {
                    "",
                    "",
                    "Employee / Manager RRsignature",
                    ".......................John"
                },
                "vat number": "VAT No: 787655678",
                "bottom message": {
                    "Thank You For Your Custom",
                    "See You Soon",
                    "MERRY CHRISTMAS",
                    "www.theepsomclub.com"
                },
                "receipt header": {
                    "The TESTING CLUB",
                    "Tel: 061 319SS66  VAT: GB3158927S",
                    "41-43 Chruch Street",
                    "Epsom KT17 4QW"
                },
                "report message": {
                    "",
                    "",
                    "",
                    ""
                },
                "commercial message": {
                    "The Club is Open 1000-2200 Daily",
                    "",
                    "",
                    ""
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
                
                "points": {
                    "gain": "",
                    "collect": "",
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
                    "stock_cost":""
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
                "group": "",
                "status": "",
                "description": "",
                "value": "",
                "setting_key_type": ""
            }
        }',

        'setting_key_type' => '{}',

        'setting_group' => '{
            "default_country": "",
            "stock_cost": "",
            "special_stock_cost": ""
        }',

        'setting_customer' => '{
            "customer_stock_cost": "",
            "customer_credit": "",
            "customer_print": {},
            "customer_marketing": {}
        }',
       
      
    ];

    protected $casts = [

        
        'setting_logo' => 'array',
       

        'setting_stock_group' => 'array',
        
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
        'setting_key_type' => 'array',
        'setting_group' => 'array',
        'setting_customer' => 'array',
        'setting_preset_message' => 'array',
        'setting_price_level_scheduler' => 'array'
    ];

    public static function SettingTable(){
        return Setting::
        rightJoin('person', 'person.person_id', 'setting.settingtable_id');
        rightJoin('company', 'company.company_id', 'setting.settingtable_id');
    }


    /* public static function SettingKey()
    {
        //  0 , 1 , 2
        return ['finalise', 'status', 'transtype'];
    }
 */
    public static function List($column, $filter)
    {

        return Setting::leftJoin('store', 'store.store_id', '=', 'setting.settingtable_id');
    }

    public static function Account($column, $filter)
    {

        $setting = Setting::where($column, $filter)
            ->first();

        if ($setting) {
            return $setting;
        } else {
            return new Setting();
        }
    }

    public static function SettingOfferStatus()
    {
        return [
            'Enabled',
            'Disabled'
        ];
    }

    public static function SettingKeyType()
    {

        return [
            "VOUCHER",
            "CASH",
            "CREDIT",
            "TERMINAL",
            
            //"DISCOUNT",
            //"DELIVERY"
        ];

      
    }

    public static function SettingOfferType()
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

    public static function SettingStockGroup(){
       
        return [
            "category", 
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


    public static function SettingKey($setting, $value){
        
        $key = array_search($value, $setting->setting_key_type);

        return collect($setting->setting_key)->where('setting_key_type', $key)->first();
    }

    public static function OfferType(){
        return [
            'voucher', //coupons
            'discount', //one offs
            'multiple-buy',
            'mix-match'
        ];
    }

   

    //session and grand total
    public static function SettingFinaliseKey($data, $receipt = null){

        //$data['request'] = ['type' => null];
/* 
        if ($data['request']->session()->has('setting_finalise_key')) {
            $data['request'] = $data['request']->session()->get('setting_finalise_key');
        } */
        
        
        $setupList = [];
        $setupList = $data['request']->session()->pull('user-session-'.Auth::user()->user_id.'.'.'setupList');


        //cash
        if ($data['request']->session()->get('type') == 'cash' && $data['request']['value']) {
            $setupList[$data['request']][] = [
                'value' => $data['request']['value'],
                'type' => $data['request']->session()->get('type')
            ];
        }
        
        //credit
        if ($data['request']->session()->get('type') == 'credit' && $data['request']['value']){
            $customer =  $setupList['customer'];
            $this->personModel = Person::find($customer['value']);

            $setupList[$data['request']][] = [
                'value' => $data['request']['value'],
                'type' => $data['request']->session()->get('type')
            ];

        }
        
          //delivery
        if ($data['request']->session()->get('type') == 'delivery' && $data['request']['value']){

            $setupList[$data['request']->session()->get('type')][] = [
                'value' => $data['request']['value'],
                'type' => $data['request']->session()->get('type')
            ];
        }

        //voucher
        if ($data['request']->session()->get('type') == 'voucher' && $data['request']['value']){
            foreach ($data['settingModel']->setting_offer as $key => $value) {
                if ($value['string']['barcode'] === $data['request']->session()->get('searchInputID') && 
                $value['date']['end_date'] > Carbon::now() &&
                array_search( Carbon::now()->dayOfWeek, $value['available_day']) ) {

                    $data['settingModel']->setting_offer = [ $key => $value ];
                    $setupList[$data['request']->session()->get('type')][] = [ 
                        'discount_type' => $value['decimal']['discount_type'],
                        'discount_value' => $value['decimal']['discount_value'] 
                    ];
                    break;
                  
                }
            }
        }
        
        //discount
        if ($data['request']->session()->get('type') == 'discount' && $data['request']['value']){
        
            if ( Str::contains($data['request']['value'], '%') ) {
                $discountValue = Str::remove('%', $data['request']['value']);
                $discount_type = 0;
                $setupList[$data['request']->session()->get('type')][] = ['discount_type' => $discount_type, 'discount_value' => $discountValue];
            }  
            elseif($data['request']['value'] != null) {
                $discountValue = $data['request']['value'];
                $discount_type = 1;
                $setupList[$data['request']->session()->get('type')][] = ['discount_type' => $discount_type, 'discount_value' => $discountValue];
            }
            
        }
         
     
        $data['request']->session()->put('user-session-'.Auth::user()->user_id.'.'.'setupList', $setupList);

       

        return Setting::ReCalculate($receipt, $setupList);
        
    }


    //recalculate receipt
    public static function ReCalculate($receipt, $setupList){

        if ($receipt && $setupList) {

            //discount
            if (count($setupList[ 'discount' ]) > 0) {
                
                foreach ( $setupList[ 'discount' ] as $key => $value) {
                    
                    //check if value has percentage
                    if ($value['discount_type'] == array_search('percentage', Setting::SettingOfferType()) ) {
                        $receipt['totalPrice'] = MathHelper::Discount($value['discount_value'], $receipt['totalPrice']);
                        $receipt['discountPercentageTotal'] = $receipt['discountPercentageTotal'] + $value['discount_value'];
                    } else {
                        $receipt['totalPrice'] = $receipt['totalPrice'] - $value['discount_value'];
                        $receipt['discountAmountTotal'] = $receipt['discountAmountTotal'] + $value['discount_value'];
                    }
                }

                
            }


            if ( count($setupList[ 'delivery' ]) > 0 ) {
                $receipt['deliveryTotal'] = $receipt['deliveryTotal'] + collect($setupList[ 'delivery' ])->sum('value');
                $receipt['totalPrice'] = $receipt['totalPrice'] + $receipt['deliveryTotal'];
            }

            if (count($setupList[ 'voucher' ]) > 0) {
                foreach ($setupList[ 'voucher' ] as $key => $value) {
                        
    
                    //check if value has percentage
                    if ($value['discount_type'] == array_search('percentage', Setting::SettingOfferType()) ) {
                        $receipt['totalPrice'] = MathHelper::Discount($value['discount_value'], $receipt['totalPrice']);
                        $receipt['voucherPercentageTotal'] = $receipt['voucherPercentageTotal'] + $value['discount_value'];
                    } else {
                        $receipt['totalPrice'] = $receipt['totalPrice'] - $value['discount_value'];
                        $receipt['voucherAmountTotal'] = $receipt['voucherAmountTotal'] + $value['discount_value'];
                    }
                }
               
            }



            //customer 
            if ( count($setupList['customer']) > 0 ){

                $customer = $setupList['customer'];
                $personModel = Person::find($customer['value']);
                $companyModel = Company::find($personModel->persontable_id);

                if ($personModel) {
                    $settingModel = Setting::SettingTable()
                    ->where('setting.settingtable_id', $companyModel->company_id)
                    ->first();
                }
                
                if ($companyModel) {
                    $settingModel = Setting::SettingTable()
                    ->where('setting.settingtable_id', $personModel->person_id)
                    ->first();
                }
                
                

                if ($settingModel) {
                    if ( $settingModel->setting_customer) {

                        if ($settingModel->setting_customer['customer_stock_cost']) {
                            # code...
                        }

                       /* foreach ($settingModel->setting_customer as $setting_customer) {
                           
                            if (Setting::SettingOfferType()[$setting_offer['decimal']['discount_type']] == 'percentage') {
                                $value =  MathHelper::Discount($setting_offer['decimal']['discount_value'], $receipt['totalPrice']); //percentage to amount
                                $percentage = $setting_offer['decimal']['discount_value'];
                            } else{
                                $value = $setting_offer['decimal']['discount_value'];
                                $percentage = MathHelper::PercentageDifference($setting_offer['decimal']['discount_value'], $receipt['subTotal']);
                            }
        
                            $receipt['customerDiscount'] = [
                                'discount_type' => $setting_offer['decimal']['discount_type'], 
                                'discount_value' => $setting_offer['decimal']['discount_value'], 
                                'converted_value' => $value, 'converted_percentage' => $percentage 
                            ];
        
                            $receipt['totalPrice'] = $receipt['totalPrice'] - $value;
                        } */
                    }
                }

            }


            if (count($setupList['credit']) > 0) {
                $receipt['creditTotal'] = $receipt['creditTotal'] + collect()->sum('value');
                $receipt['totalPriceVAT'] = $receipt['totalPriceVAT'] - $receipt['creditTotal'];
            }

            if ( count($setupList[ 'cash' ]) > 0 ) {
                $receipt['cashTotal'] = $receipt['cashTotal'] + collect()->sum('value');
                $receipt['totalPriceVAT'] = $receipt['totalPriceVAT'] - $receipt['cashTotal'];
            }

        }

        return $receipt;
    }

    //compare current
    public static function SettingCurrentOffer($stock, $offerType){
        
        $stockOffer = [];
        

        if ($stock->stock_merchandise['setting_offer_id']) {

            $userModel = User::Account('account_id', Auth::user()->user_account_id)
            ->first();

            $settingModel = Setting::where('settingtable_id', $userModel->store_id)->first();

            $setting_offer = collect($settingModel->setting_offer)->only( $stock->stock_merchandise['setting_offer_id'] );

            //filter offer by date 
            foreach ($setting_offer as $stock_offer_key => $stock_offer_value) {
                if ( $stock_offer_value['date']['start_date'] >= Carbon::now() && $offerType == $stock_offer_value['boolean']['type']) {
                    
                    //discount days
                    if (array_search( Carbon::now()->dayOfWeek, $stock_offer_value['available_day'] )) {
                        $stockOffer[$stock_offer_key] = $stock_offer_value;
                    }

                }
            }
        }

        return $stockOffer;
    }


    //stock
    public static function SettingCurrentOfferType($settingCurrentOffer, $price){


        
        $settingCurrentOfferType = 0;
        $total = [];

        foreach ($settingCurrentOffer as $settingCurrentOfferKey => $settingCurrentOfferValue) {
            
            if (Setting::SettingOfferType()[$settingCurrentOfferValue['decimal']['discount_type']] == 'percentage') {

                $settingCurrentOfferType = ['price'  => MathHelper::Discount($settingCurrentOfferValue['decimal']['discount_value'], $price)];
               
            } else {
                $settingCurrentOfferType = ['price' => $price - $settingCurrentOfferValue['decimal']['discount_value'] ];
               
            }


            if (count($settingCurrentOfferType) > 0) {
                $total[$settingCurrentOfferKey] = $settingCurrentOfferValue;
                $total[$settingCurrentOfferKey] += ['total' => $settingCurrentOfferType];
            }

        }
      
        //collect($settingCurrentOfferType)->min('price')
        
        

        return $total;
    }

    public static function SettingKeyGroup(){
        return [
            '1' => 'finalise-key', //coupons
            '2' => 'status-key', //one offs
            '3' =>'transaction-key'
        ];
    }



}
