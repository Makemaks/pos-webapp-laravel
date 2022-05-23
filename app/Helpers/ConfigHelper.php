<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ConfigHelper
{

    public static function EmployementFunction()
    {

        return [
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
        ];
    }

    public static function EmployementMode()
    {
        return [
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
        ];
    }

    public static function EmployementEmployeeJob()
    {

        return [
            "Promt to clocked in at sign on",
            "Compulsory clocked in"
        ];
    }

    public static function EmployementUserControl()
    {
        return [
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
        ];
    }

    public static function TerminalFlag()
    {

        for ($i = 0; $i < 15; $i++) {
            $flag[$i + 1] = $i + 1;
        }

        return [

            'Status Flags' => [
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
            'Commission Rates' => $flag,
            'Selective Itemisers' => $flag,
            'Stock Control (EPOS side only)' => [

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
            ['ref' => 1, 'name' => 'Energy', 'value' => '4934', 'measurement' => 'kcal'],
            ['ref' => 2, 'name' => 'Fat', 'value' => '4892', 'measurement' => 'g'],
            ['ref' => 3, 'name' => 'Saturate', 'value' => '4057', 'measurement' => 'g'],
            ['ref' => 4, 'name' => 'Carbohydrate', 'value' => '3164', 'measurement' => 'g'],
            ['ref' => 5, 'name' => 'Sugar', 'value' => '767', 'measurement' => 'g'],
            ['ref' => 6, 'name' => 'Protein', 'value' => '1660', 'measurement' => 'g'],
            ['ref' => 7, 'name' => 'Salt', 'value' => '4841', 'measurement' => 'g'],
            ['ref' => 8, 'name' =>  'Portions', 'value' => '2210', 'measurement' => 'g']
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
}
