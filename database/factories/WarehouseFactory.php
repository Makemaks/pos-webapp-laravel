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
        }

       

        return [

                "warehousetable_id" => $this->faker->numberBetween($min = 1, $max = 10),
                "warehousetable_type" =>  $this->faker->randomElement($array = array ('Store')),
                "warehouse_reason" => $stock_reason,
                "warehouse_store_id" => $this->faker->numberBetween($min = 1, $max = 10),
                "warehouse_stock_id"=> $this->faker->numberBetween($min = 1, $max = 100),
                "warehouse_user_id"=> $this->faker->numberBetween($min = 1, $max = 2),
                "warehouse_price_override"=> $this->faker->randomElement($array = array (NULL,$this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50))),
                "warehouse_quantity"=>  $this->faker->numberBetween($min = 1, $max = 50),
                "warehouse_reference" => $this->faker->randomElement($array = array (NULL,$this->faker->word)),
                "warehouse_note" => $this->faker->randomElement($array = array (NULL,$this->faker->sentence)),
                "warehouse_type" => $this->faker->numberBetween($min = 0, $max = 3),
                "warehouse_company_id" => $this->faker->numberBetween($min = 1, $max = 10),

            
        ];
    }
}
