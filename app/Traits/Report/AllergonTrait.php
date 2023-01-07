<?php

namespace App\Traits\Report;

use App\Models\Setting;
use App\Models\Stock;
use App\Models\Warehouse;

trait AllergonTrait 
{   

    /**
     * this function is used to get allergen plu report
     * @return array 
     */
    public function getAllergenPluReport() :array
    {
        $settings = Setting::select('setting_stock_group')->get(); 
        foreach($settings as $setting) {
            $key = 0;
            foreach($setting->setting_stock_group as $pluId => $settngStockGroup) {
                if($settngStockGroup['type'] == '2') {
                    $collectPluIds[$key]['plu_id'] = $pluId;
                    $collectPluIds[$key]['plu_name'] = $settngStockGroup['name'];
                }
                 $key++;
            }
        }
        return $collectPluIds;
    }
}