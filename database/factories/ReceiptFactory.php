<?php

namespace Database\Factories;
use App\Models\Receipt;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Receipt>
 */
class ReceiptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
     
        return [
            'receipttable_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'receipttable_type' => $this->faker->randomElement($array = array ('Stock')),
            'receipt_warehouse_id' => $this->faker->randomElement($array = array (NULL, $this->faker->numberBetween($min = 1, $max = 10))),
            'receipt_user_id' => $this->faker->numberBetween($min = 1, $max = 2),
            
            'receipt_order_id' => $this->faker->numberBetween($min = 1, $max = 10),
          
            'receipt_setting_pos_id' => $this->faker->numberBetween($min = 1, $max = 5)
        ];
    }
}
