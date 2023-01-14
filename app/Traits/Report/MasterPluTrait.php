<?php

namespace App\Traits\Report;

use App\Models\Setting;
use App\Models\Stock;
use App\Models\Warehouse;

trait MasterPluTrait 
{   

    /**
     * this function is used to get master plu report
     * @return array 
     */
    public function getMasterPluReport() :array
    {
        $settings = Setting::select('setting_stock_set')->get(); 
        foreach($settings as $setting) {
            $key = 0;
            foreach($setting->setting_stock_set as $pluId => $settngStockGroup) {
                if($settngStockGroup['type'] == '2') {
                    $collectPluIds[$key]['plu_id'] = $pluId;
                    $collectPluIds[$key]['linked_to_master_plu'] = $settngStockGroup['name'];
                    $collectPluIds[$key]['random_code'] = $settngStockGroup['code'];
                }
                 $key++;
            }
        }
        foreach($collectPluIds as $key => $collectPluId) {
            $stock = Stock::whereJsonContains('stock_merchandise', ['plu_id' => $collectPluId['plu_id']])->first();
            $warehouseQuantity = Warehouse::where('warehouse_stock_id', $stock->stock_id)->sum('warehouse_quantity');
            $collectPluIds[$key]['linked_to_master_plu'] = '['.Stock::whereJsonContains('stock_merchandise', ['plu_id' => $collectPluId['plu_id']])->count().']' .' '. $collectPluId['linked_to_master_plu'];
            $collectPluIds[$key]['name'] = $stock->stock_merchandise['stock_name'];
            $collectPluIds[$key]['master_plu_qty'] = $warehouseQuantity;
        }
        return $collectPluIds;
    }
}