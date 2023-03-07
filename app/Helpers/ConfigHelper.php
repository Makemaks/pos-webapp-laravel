<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ConfigHelper
{

    public static function EmploymentFunction()
    {

        return [
            "Allowed Function" => [
                "No Sale",
                "New Check and Old Check Key",
                "Split Check",
                "Credit Card Capture",
                "Item Correct",
                "Check Transfer",
                "Deposit",
                "House Bon",
                "Void",
                "+ Amount",
                "Pay Account",
                "View Open Checks",
                "Cancel",
                "- Amount",
                "Customer Enquiry",
                "Edit Check Text",
                "Refund",
                "+%",
                "Hot Card Button",
                "CASH2 Key",
                "Price Shift",
                "-%",
                "Customer Transfer",
                "Minimise TouchPoint",
                "Price Level Shift",
                "Exchange Points",
                "Service Charge Key",
                "Menu Shift 2",
                "Menu Level Shift",
                "Suspend and Resume",
                "View Customer Detail",
                "Media Exchange",
                "View Active Clerk List",
                "Paid Out",
                "Remote Journal View",
                "Launch Batch",
                "New Check Key",
                "Received on Account",
                "Global Eat In/Take Out",
                "Points Adjustment",
                "Old Check Key",
                "Temporary Price Change",
                "Edit Customer",
                "Customer Biometrics"
            ],
        ];
    }

    public static function EmploymentMode()
    {
        return [
            "Allowed Modes" => [
                "Reg Mode",
                "Refund Mode",
                "X Mode",
                "Z Mode",
                "Manager Functions",
                "Program 1",
                "Program 2",
                "Program 3",
                "Program 4",
                "Program 5",
                "Program 6",
            ],
        ];
    }

    public static function EmploymentEmployeeJob()
    {

        return [
            "Employee Job" => [
                "Promt to clocked in at sign on",
                "Compulsory clocked in"
            ],
        ];
    }

    public static function EmploymentUserControl()
    {
        return [
            "User Control" => [
                "Use 2nd Drawer?",
                "User is Manager",
                "User is Trainee",
                "Allowed to open other clerk's checks?",
                "Allowed to correct items from checks?",
                "Defaults to floor plan at sign on?",
                "Last item error correct only?",
                "Compulsory order number entry",
                "Compulsory number of covers entry",
                "Compulsory check number",
                "Compulsory customer?",
                "Prompt for customer number",
                "Prompt for Eat In/Take Out",
                "Sign off clerk at close of sale?",
                "Non Turnover? {TMS/PLU sales only}"
            ],
        ];
    }

    public static function EmploymentKey()
    {
        return [
            'ibutton' => 'iButton',
            'secret_number' => 'Secret Number',
            'ni_number' => 'NI Number',
            'default_menu_level' => 'Default Menu Level',
            'default_price_level' => 'Default Price Level',
            'default_floorplan_level' => 'Default Floorplan Level',
            'pay_rate' => 'Pay Rate',
            'from_date' => 'From Date',
            'to_date' => 'To Date',
            'start_hour' => 'Start Hour',
            'end_hour' => 'End Hour',
            'rate_1' => 'Rate 1',
            'rate_2' => 'Rate 2',
            'rate_3' => 'Rate 3',
            'rate_4' => 'Rate 4',
        ];
    }

    public static function EmploymentTable()
    {
        return [
            'employment_general' => 'General',
            'employment_level_default' => 'Level Default',
            'employment_commision' => 'Commision',
            'employment_user_pay' => 'User Pay'
        ];
    }

    public static function EmploymentEachTable()
    {
        return [
            'employment_general' => [
                'ibutton',
                'secret_number',
                'ni_number',
            ],
            'employment_level_default' => [
                'default_menu_level',
                'default_price_level',
                'default_floorplan_level',
            ],
            'employment_commision' => [
                'rate_1',
                'rate_2',
                'rate_3',
                'rate_4',
            ],
            'employment_user_pay' => [
                'pay_rate',
                'from_date',
                'to_date',
                'start_hour',
                'end_hour',
            ]
        ];
    }



    public static function default_menu_level()
    {
        return [
            "Drinks",
            "Food"
        ];
    }

    public static function default_price_level()
    {
        return [
            "Level 1",
            "Level 2"
        ];
    }

    public static function TerminalFlag()
    {

        for ($i = 0; $i < 15; $i++) {
            $flag[$i + 1] = $i + 1;
        }

        return [
          
            'status_flag' => [
              'Enable Zero Price Sale',
              'Do not print on receipts or bills',
              'PLU is Negative Price',
              'Allow manual weight entry',
              'Enable Preset Override',
              'Enable SEL Printing',
              'High Digit Limit 	Flag as Pending SEL',
              'PLU is Condiment PLU',
              'Single item sale',
              'PLU is Weight PLU',
              'Set menu premium item (uses 3rd @)',
              'Prompt with notes',
              'Prompt Customer Verification 1',
              'Prompt with picture',
              'Prompt Customer Verification 2',
            ],
            'commission_rate' => $flag,
            'selective_itemiser' => $flag,
            'stock_control' => [
              	
                'SEL Unit',
                'SEL Quantity',
                'Minimum Stock',
                'Maintain Stock',
                'Error when minimum stock reached',
                'Inhibit sales when below minimum stock',
                'Display stock quantity on keyboard'
            ]

        ];
    }


    //label (Location 	Facings 	Qty of Type 	Type ) )
    public static function Labels()
    {
        return [

            'SHELF' => [
                "DEFAULT TEMPLATES" => [
                    "A4" => "A4 (24 labels [3x8], 60x30mm) - 210mm x 297mm",
                    "A4 SPAR" => "A4 SPAR (24 labels [3x8], 67.5x34mm) - 210mm x 297mm",
                    "EU30016WX" => "EU30016WX (24 labels [3x8], 63.5 x 33.9mm) - 210mm x 297mm",
                    "SECC21LCE" => "SECC21LCE (21 labels [3x7], 70 x 37.5mm) - 210mm x 297mm",
                    "SRP-770II 38x25" => "SRP-770II 38x25 (BIXILON Single label roll, 38 x 25mm) - 38mm x 25mm",
                    "SRP-770II 45x35" => "SRP-770II 45x35 (BIXILON Single label roll, 45 x 35mm) - 45mm x 35mm",
                    "DA402 80x38" => "DA402 80x38 (ZEBRA Single label roll, 80 x 38mm) - 80mm x 38mm",
                    "DK-1201" => "DK-1201 (Single label roll, 90 x 29mm) - 90mm x 29mm",
                    "GK420t" => "GK420t (Single label feed, 48.5 x 35mm) - 49mm x 35mm",
                    "A4 (Allergens)" => "A4 (Allergens) (8 labels [1x8], 120x30mm) - 210mm x 297mm",
                    "A4 (Alternative Text)" => "A4 (Alternative Text) (24 labels [3x8], 60x30mm) - 210mm x 297mm",

                ],

                "CUSTOM TEMPLATES" => [],
            ],

            'STOCK' => [
                "DEFAULT TEMPLATES" => [
                    "DK-1201" => "DK-1201 - 90mm x 29mm",
                    "DK-22210" => "DK-22210 - 100mm x 29mm",
                    "DK-11204" => "DK-11204 - 54mm x 17mm",
                    "SLP-MRL" => "SLP-MRL - 51mm x 28mm",
                    "SRP-770II 38x25" => "SRP-770II 38x25 - 38mm x 25mm",
                    "SRP-770II 45x35" => "SRP-770II 45x35 - 45mm x 35mm",
                    "DK-1201 (Allergens)" => "DK-1201 (Allergens) - 90mm x 29mm",
                    "DK-1201 (Alternative Text)" => "DK-1201 (Alternative Text) - 90mm x 29mm",
                ],

                "CUSTOM TEMPLATES" => [],

            ],


        ];
    }

    public static function MixMatchType()
    {
        return [
            'Discount amount',
            'Discount %',
            'Set Price',
            'Discount amount cheapest',
            'Discount % cheapest',
            'Discount amount last item',
            'Discount % last item'
        ];
    }

    public static function Nutrition()
    {
        return [
            ['name' => 'Energy', 'value' => '4934' ,'measurement' => 'kcal'],
            ['name' => 'Fat', 'value' => '4892' ,'measurement' => 'g'], 	
            ['name' => 'Saturate', 'value' => '4057' ,'measurement' => 'g'], 
            ['name' => 'Carbohydrate', 'value' => '3164' ,'measurement' => 'g'], 
            ['name' => 'Sugar', 'value' => '767' ,'measurement' => 'g'], 	
            ['name' => 'Protein', 'value' => '1660' ,'measurement' => 'g'], 	
            ['name' => 'Salt', 'value' => '4841' ,'measurement' => 'g'], 
            ['name' =>  'Portions', 'value' => '2210' ,'measurement' => 'g'] 
        ];
    }

    public static function Allergen()
    {
        return [
            'Celery',
            'Cereals Containing Gluten',
            'Crustaceans',
            'Eggs',
            'Fish',
            'Lupin',
            'Milk',
            'Molluscs',
            'Mustard',
            'Tree Nuts',
            'Peanuts',
            'Sesame Seeds',
            'Soyabeans',
            'Sulphur Dioxide and Sulphites',
            'Allergen 15',
            'Allergen 16',
        ];
    }


    public static function SettingReceipt(){
        return [
            '{
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
            }'
       
        ];
    }

    public static function SettingStockLabel(){
        return [
            
            '{
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
            }'
       
        ];
    }

    public static function SettingAllergen(){
        return [
            "Celery",
            "Cereals Containing Gluten",
            "Crustaceans",
            "Eggs",
            "Fish",
            "Lupin",
            "Milk",
            "Molluscs",
            "Mustard",
            "Tree Nuts",
            "Peanuts",
            "Sesame Seeds",
            "Soyabeans",
            "Sulphur Dioxide and Sulphites",
            "Allergen 15",
            "Allergen 16" 
                
        ];
    }

    public static function SettingCustomerPrint(){
        return [
            'Print last transaction date on receipt',
            'Print account number on receipt',  
            'Print spend today on receipt',
            'Print customer address on receipt',
            'Print times used today on receipt',
            'Print phone number on receipt',
            'Print spend to date on receipt',
            'Print customer name on KP',
            'Print spend towards discount on receipt',
            'Print customer address on KP',
            'Print discount total on receipt',
            'Print customer notes on KP',
            'Shift to price level 2?',
            'Print phone number on KP',
            'Prompt with picture if present?',
            'Also print customer details on KV?',
        ];
    }
    
  
}
