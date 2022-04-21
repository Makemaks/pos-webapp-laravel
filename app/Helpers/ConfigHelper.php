<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ConfigHelper{


    public static function Setup(){
        return [
             
              'Modes'=>[
                  "Reg Mode",
                  "Refund Mode",
                  "X Mode",
                  "Z Mode",
                  "Manager Functions",
                ],
              'Function' => [
                "No Sale",
                "New Check/Old Check Key",
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
                "Suspend/Resume",
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
            ]
        ];
    }
  
    public static function TerminalFlags(){

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
            'Commission Rates' => ['Rate'],
            'Selective Itemisers' => ['Itemiser'],
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


    
  
}


