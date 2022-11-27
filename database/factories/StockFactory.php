<?php

namespace Database\Factories;

use App\Helpers\ConfigHelper;
use App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        for ($i = 0; $i < 6; $i++) {

           

            $stock_supplier[$i + 1] = [
                'supplier_id' => $this->faker->numberBetween($min = 1, $max = 5),
                'code' => $this->faker->randomElement($array = array(NULL, $this->faker->numberBetween($min = 20000, $max = 50000))),
                'unit_cost' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                'case_cost' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                'default' => $this->faker->numberBetween($min = 0, $max = 1),
            ];

          
            for ($i = 0; $i < $this->faker->numberBetween($min = 1, $max = 5); $i++) {
                $setting_plu[$i + 1] = $this->faker->numberBetween($min = 1, $max = 5);
            }

            $stock_web[$i + 1] = [
                "plu" => $setting_plu,
                "min" => $this->faker->numberBetween($min = 1, $max = 50),
                "max" => $this->faker->numberBetween($min = 1, $max = 50),
                "price" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 500),
                "default" => 1,
                "offer_id" => $this->faker->randomElement($array = array(NULL, $this->faker->numberBetween($min = 1, $max = 5))),
            ];
        }

        $stock_gross_profit = [
            'target' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
            'actual' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
            'rrp' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
            'average_cost' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
        ];


        for ($i = 0; $i < $this->faker->numberBetween($min = 1, $max = 5); $i++) {
            $setting_offer_id[$i + 1] = $this->faker->numberBetween($min = 1, $max = 5);
        }
        $stock_merchandise = [

            "recipe_link" => $this->faker->numberBetween($min = 1, $max = 5),
            "case_size" => $this->faker->numberBetween($min = 1, $max = 5),

            "group_id" => $this->faker->numberBetween($min = 1, $max = 20),
            "category_id" => $this->faker->numberBetween($min = 1, $max = 5),
            "brand_id" => $this->faker->numberBetween($min = 1, $max = 20),

            'random_code' => $this->faker->randomElement($array = array(NULL, $this->faker->numberBetween($min = 20000, $max = 50000))),
            'expiration_date' => 0,
            'alert_level' => $this->faker->numberBetween($min = 1, $max = 10),
            "non_stock" => $this->faker->numberBetween($min = 0, $max = 1),
            "current_stock" => $this->faker->numberBetween($min = 200, $max = 200),
            "minimum_stock" => $this->faker->numberBetween($min = 1, $max = 50),
            "maximum_stock" => $this->faker->numberBetween($min = 50, $max = 100),
            "days_to_order" => $this->faker->numberBetween($min = 1, $max = 5),
            "plu_id" => $setting_plu,
            "qty_adjustment" => $this->faker->numberBetween($min = 100, $max = 800),

            "unit_size" => $this->faker->numberBetween($min = 1, $max = 20),

            "outer_barcode" => $this->faker->ean13,
            "stock_vat_id" => $this->faker->randomElement($array = array(NULL, $this->faker->numberBetween($min = 1, $max = 5))),
            'stock_name' => $this->faker->word,
            'stock_description' => $this->faker->paragraph,
            "set_menu" => $this->faker->numberBetween($min = 1, $max = 5),
            "stock_tag" => $this->faker->numberBetween($min = 1, $max = 5),
            "setting_offer_id" => $this->faker->randomElement($array = array(NULL, $setting_offer_id)),
            "stock_type"=> $this->faker->numberBetween($min = 0, $max = 1),
            "stock_maximum_cart_quantity" => $this->faker->randomElement($array = array(NULL, $this->faker->numberBetween($min = 1, $max = 2) )),
            "alternative_text" => '',
            "master_plu_id" =>  $this->faker->randomElement($array = array(NULL, $this->faker->numberBetween($min = 1, $max = 20) )),
        ];

        for ($i = 0; $i < 15; $i++) {
            $flag[$i + 1] = $i;
        }

        foreach (ConfigHelper::TerminalFlag() as $key => $value) {
            $stock_terminal_flag[$key] = $this->faker->shuffle($flag);
        }

        for ($i=0; $i < count(ConfigHelper::Nutrition()); $i++) { 
            $stock_nutrition[$i + 1] = [
                'setting_stock_id' => $i+1,
                'value' => ConfigHelper::Nutrition()[$i]['value'],
                'measurement' => ConfigHelper::Nutrition()[$i]['measurement'],
            ];
        }

        for ($i = 0; $i < rand(1, 8); $i++) {
            $stock_allergen[$i + 1] = $i + 1;
        }

        $stock_price = [];
        for ($i=0; $i < 10; $i++) { 
                
            $stock_price[$i + 1] = [
                "price" =>  $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 20),
                "schedule_datetime" =>  "",
                "stock_price_group_id"  => $this->faker->numberBetween($min = 1, $max = 5)
            ];
            
        }
        

        for ($j=0; $j < 5; $j++) { 
                
            $stock_price_quantity[$j + 1] = 
            [
                "stock_price_quantity" => $this->faker->numberBetween($min = 1, $max = 200),
                "stock_price_group_id" => $this->faker->numberBetween($min = 1, $max = 5),
            ];
           
        }


        $stock_manager_special = $this->faker->randomElement($array = array(NULL, $this->faker->numberBetween($min = 1, $max = 5)));

        if ($stock_manager_special != NULL) {
            $stock_manager_special = [];
            for ($j=0; $j < 2; $j++) { 
                $stock_manager_special[$j + 1][1] = ['price' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 20)];
            }
        }
       
       

        return [


            'stock_price' => $stock_price,
            'stock_supplier' => $stock_supplier,
            'stock_store_id' => $this->faker->numberBetween($min = 1, $max = 10),

            'stock_gross_profit' => $stock_gross_profit,


            'stock_merchandise' => $stock_merchandise,


            'stock_terminal_flag' => $stock_terminal_flag,
            'stock_web' => $stock_web,
            'stock_nutrition' => $stock_nutrition,
            'stock_allergen' => $stock_allergen,
            'stock_price_quantity' => $stock_price_quantity,
            'stock_manager_special' => $stock_manager_special,


        ];
    }
}
