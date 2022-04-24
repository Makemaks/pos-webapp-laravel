<?php
namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ControllerHelper{


    public static function Controller(){
       
        $controllers = [];

        foreach (Route::getRoutes()->getRoutes() as $route)
        {
            $action = $route->getAction();
        
            if (array_key_exists('controller', $action))
            {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
               
                $controllers[] = $action['controller'];

                if (Str::contains($action['controller'], '@') && 
                Str::contains($action['controller'], 'index') && 
                Str::contains($action['controller'], 'Cart') == false &&
                Str::contains($action['controller'], 'Chart') == false &&
                Str::contains($action['controller'], 'Activity') == false &&
                Str::contains($action['controller'], 'Receipt') == false &&
                Str::contains($action['controller'], 'Person') == false &&
                Str::contains($action['controller'], 'Address') == false &&
                Str::contains($action['controller'], 'Company') == false &&
                Str::contains($action['controller'], 'Scheme') == false &&
                Str::contains($action['controller'], 'Payment') == false &&
                Str::contains($action['controller'], 'API') == false) {
                    $controller = Str::afterLast($action['controller'], '\\');
                    $routeController[] = Str::beforeLast( $controller, 'Controller@');
                }

            }
        }

        $routeController[] = 'Home';
        sort($routeController);

        return array_unique($routeController);
    }

    public static function UserSetting(){
        
            $array = [
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
            ];
    }
  
}


