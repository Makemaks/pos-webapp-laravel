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
        $settings = Setting::select('setting_stock_set','setting_id')->get(); 
        foreach($settings as $setting) {
            $key = 0;
            foreach($setting->setting_stock_set as $pluId => $settngStockGroup) {
                if($settngStockGroup['type'] == '2') {
                    $collectPluIds[$key]['plu_id'] = $pluId;
                    $collectPluIds[$key]['plu_name'] = $settngStockGroup['name'];
                    $collectPluIds[$key]['setting_id'] = $setting->setting_id;
                }
                 $key++;
            }
        }
        foreach($collectPluIds as $key => $collectPluId) {
            $stock = Stock::whereJsonContains('stock_set', ['plu_id' => $collectPluId['plu_id']])->first();
            $settingAllergen = Setting::where('setting_id', $collectPluId['setting_id'])->pluck('setting_stock_allergen')->first();
            foreach($stock->stock_allergen as $allergenKey => $stockAllergenValue) {
                $exchangedValue[] = $settingAllergen[$stockAllergenValue];
            }
            $collectPluIds[$key]['plu_allergen'] = $exchangedValue;
        }
        return $collectPluIds;
    }
}