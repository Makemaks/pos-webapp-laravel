<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stockroom>
 */
class StockroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [

                "stockroom_store_id" => $this->faker->numberBetween($min = 1, $max = 10),
                "stockroom_stock_id"=> $this->faker->numberBetween($min = 1, $max = 100),
                "stockroom_user_id"=> $this->faker->numberBetween($min = 1, $max = 2),
                "stockroom_price"=> $this->faker->randomElement($array = array (NULL,$this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50))),
                "stockroom_quantity"=>  $this->faker->numberBetween($min = 1, $max = 50),
               
                "stockroom_type" => $this->faker->numberBetween($min = 0, $max = 1),
        ];
    }
}
