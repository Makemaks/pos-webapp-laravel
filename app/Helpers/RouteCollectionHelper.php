<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class RouteCollectionHelper{




    public static function RouteUriList(){


        $routes = Route::getRoutes();        
        $apps_list = [];
        $apps_exclude = ['Home', 'Dashboard', 'Welcome'];

        // route names used to load the button in dashboard view
            foreach ($routes as $route)
            {
                $b = $route->getController();
                //get controller route with only index
                if ($route->getActionMethod() ==  'Index')
                {              
                    $a = $route->getName();
                    //ignore home and dashboard
                    $apps_list[$route->getName()] = $route->getName(); 
                }
            }
            
            $apps_list = Arr::except( $apps_list, $apps_exclude); 
         
            return $apps_list;

    }


    //Returns route list without uri
    public static function List(){


        $routes = Route::getRoutes();
            
        // route names used to load the button in dashboard view
            foreach ($routes as $route)
            {
                //get controller route with only index
                if ($route->getActionMethod() == 'Index')
                {
                
                    //ignore home and dashboard
                    if ($route->getName() != 'Home' &&  $route->getName() != 'Dashboard') {
                        $apps_list[] = Str::title($route->uri());
                    }
                
                }
            }

            return $apps_list;
    }
}