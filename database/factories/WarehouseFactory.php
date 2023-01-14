<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        for ($i=0; $i < 4; $i++) { 
            $stock_reason[$i + 1] = [
                "type" => $this->faker->numberBetween($min = 0, $max = 4), 	
                "description" => $this->faker->sentence,
            ];

            
          
            $warehouse_stock_price_quantity[$i + 1] = [
                "setting_stock_price_group_id" => $this->faker->numberBetween($min = 1, $max = 5),
                "warehouse_stock_price_quantity" => $this->faker->numberBetween($min = 1, $max = 200),
            ];
        }


        $warehouse_stock_price = [];
        for ($j=0; $j < 5; $j++) { 
            for ($i=0; $i < 10; $i++) { 
                
                $warehouse_stock_price[$j + 1][$i + 1] = [
                    'name' => $this->faker->word,
                    "description" =>  $this->faker->sentence,
                    "price" =>  $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 20),
                    "schedule_datetime" =>  "",
                    "setting_stock_price_group_id"  => $this->faker->numberBetween($min = 1, $max = 5)
                ];
            }
        }


       

        return [

                "warehousetable_id" => $this->faker->numberBetween($min = 1, $max = 10),
                "warehousetable_type" =>  $this->faker->randomElement($array = array ('Store')),
                "warehouse_reason" => $stock_reason,
                "warehouse_store_id" => $this->faker->numberBetween($min = 1, $max = 10),
                "warehouse_stock_id"=> $this->faker->numberBetween($min = 1, $max = 100),
                "warehouse_user_id"=> $this->faker->numberBetween($min = 1, $max = 2),
               /*  "warehouse_stock_price"=> $this->faker->randomElement($array = array (NULL,$this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50))),
                "warehouse_stock_price_quantity"=>  $this->faker->numberBetween($min = 1, $max = 50), */
                "warehouse_stock_quantity"=>  $this->faker->numberBetween($min = 1, $max = 50),
                "warehouse_name" => $this->faker->randomElement($array = array (NULL,$this->faker->word)),
                "warehouse_note" => $this->faker->randomElement($array = array (NULL,$this->faker->sentence)),
                "warehouse_type" => 2,//$this->faker->numberBetween($min = 0, $max = 3),
                "warehouse_company_id" => $this->faker->numberBetween($min = 1, $max = 10),
        ];
    }
}
