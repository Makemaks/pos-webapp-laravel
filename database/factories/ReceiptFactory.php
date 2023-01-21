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


        $count = 1;
        $receipt_stock_price = [];
        for ($j=0; $j < 5; $j++) { 
                
            for ($i=0; $i < 10; $i++) { 
                $receipt_stock_price[$count] = [
                    "price" =>  $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 20),
                    "setting_stock_price_level" => $i + 1,
                    "setting_stock_price_group" => $j,
                    "is_special_price" => $this->faker->numberBetween($min = 0, $max = 1),
                ];
                $count++;
            }
           
        }

        
     
        return [
            'receipttable_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'receipttable_type' => $this->faker->randomElement($array = array ('Stock')),
            'receipt_warehouse_id' => $this->faker->randomElement($array = array (NULL, $this->faker->numberBetween($min = 1, $max = 10))),
            'receipt_user_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'receipt_stock_price' => $receipt_stock_price,
            'receipt_order_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'receipt_setting_key' => $this->faker->numberBetween($min = 1, $max = 5),
            'receipt_setting_pos_id' => $this->faker->numberBetween($min = 1, $max = 5)
        ];
    }
}
