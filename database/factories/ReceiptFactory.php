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
        $receipt_stock_cost = [
            $this->faker->numberBetween($min = 1, $max = 5) => $this->faker->numberBetween($min = 1, $max = 10)
        ];

        $count = $this->faker->randomElement($array = array (NULL, $this->faker->numberBetween($min = 1, $max = 10)));
        $receipt_stock_cost_override = NULL;
        if ($count) {
            for ($i=0; $i < $count; $i++) { 
                $receipt_stock_cost_override[$i + 1] = [
                    "type" => $this->faker->numberBetween($min = 1, $max = 5),
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
            'receipt_stock_cost_id' => $this->faker->numberBetween($min = 1, $max = 5),
            'receipt_stock_cost' => $receipt_stock_cost,
            'receipt_stock_cost_override' => $receipt_stock_cost_override
        ];
    }
}
