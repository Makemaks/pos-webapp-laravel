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
     
        $count = $this->faker->randomElement($array = array (NULL, $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 1, $max = 2) ));
        $receipt_discount = null;
        
        if ($count) {
            for ($i=0; $i < $count; $i++) { 
                $receipt_discount[$i + 1] = [
                    "type" => $this->faker->numberBetween($min = 0, $max = 1),
                    "value" => $this->faker->numberBetween($min = 1, $max = 5)
                ];
            }
        }


        return [
            'receipttable_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'receipttable_type' => $this->faker->randomElement($array = array ('Stock')),
            'receipt_warehouse_id' => $this->faker->randomElement($array = array (NULL, $this->faker->numberBetween($min = 1, $max = 10))),
            'receipt_user_id' => $this->faker->numberBetween($min = 1, $max = 2),
            
            'receipt_order_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'receipt_stock_price' =>  $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 10, $max = 20),
            'receipt_discount' => $receipt_discount,
            'receipt_setting_pos_id' => $this->faker->numberBetween($min = 1, $max = 5)
        ];
    }
}
