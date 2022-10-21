<?php


namespace Database\Factories;

use App\Models\Order;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        for ($i = 0; $i < 5; $i++) {
            $order_finalise_key[$i + 1] = [
                'ref' => $this->faker->numberBetween($min = 1, $max = 7),
                'total' => $this->faker->numberBetween($min = 50, $max = 200),
            ];
        }

        $vat = $this->faker->randomElement($array = array (NULL, $this->faker->numberBetween($min = 1, $max = 3) ));
        $order_vat = Null;
        if ($vat) {
            for ($i = 0; $i < $vat; $i++) {
                $order_vat[$i + 1] = $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 10, $max = 20);
            }
        }


        for ($i = 0; $i < 5; $i++) {
            $order_status[$i + 1] = [
                'status' => $this->faker->numberBetween($min = 0, $max = 9),
                'updated_at' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years', $timezone = null),
                'user_id' => $this->faker->numberBetween($min = 1, $max = 10),
            ];
        }

        

        $order_group = [
            'order_total' => $this->faker->numberBetween($min = 100, $max = 200),
        ];

        return [
            'order_setting_pos_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'order_store_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'order_user_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'ordertable_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'ordertable_type' => $this->faker->randomElement($array = array( 'User', 'Company' )),
            'order_status' => $order_status,
            'order_type' => $this->faker->numberBetween($min = 0, $max = 1), //online,takeaway
            'order_finalise_key' => $order_finalise_key,
            'order_setting_vat' => $order_vat,
            'order_group' => $order_group
        ];
    }
}
