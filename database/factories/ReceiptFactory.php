<?php

namespace Database\Factories;
use App\Models\Receipt;
use App\Helpers\KeyHelper;

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

        $receipt_setting_key = Null;
        $count = $this->faker->numberBetween($min = 1, $max = 5);

        for ($i= 0; $i < $count; $i++) {

            $j = $this->faker->numberBetween( $min = 0, $max = count(KeyHelper::Type()[$i]) );

            $receipt_setting_key[$i + 1] = [
                "setting_key_group"  => $i,
                "setting_key_type" => $j,
                "value" => $this->faker->randomElement($array = array(null, $this->faker->numberBetween($min = 1, $max = 200))),
                "name"=> $this->faker->word,
                "status" => $this->faker->numberBetween($min = 0, $max = 1),
                "description" => '',
                "image" => ''
            ];

        }


        $receipt_stock_price[1] = [
            "price" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 20),
            "setting_stock_price_level" => $this->faker->numberBetween($min = 1, $max = 5),
            "setting_stock_price_group" => $this->faker->numberBetween($min = 1, $max = 10),
            "is_special_price" => $this->faker->numberBetween($min = 0, $max = 1),
        ];


        return [
            'receipttable_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'receipttable_type' => $this->faker->randomElement($array = array ('Stock')),
            'receipt_warehouse_id' => $this->faker->randomElement($array = array (NULL, $this->faker->numberBetween($min = 1, $max = 10))),
            'receipt_user_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'receipt_stock_price' => $receipt_stock_price,
            'receipt_order_id' => $this->faker->numberBetween($min = 1, $max = 20),
            'receipt_setting_key' => $receipt_setting_key,
            'receipt_setting_pos_id' => $this->faker->numberBetween($min = 1, $max = 5)
        ];
    }
}
