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
        return [
            'order_user_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'order_status' => $this->faker->numberBetween($min = 0, $max = 7),
            'order_type' => $this->faker->numberBetween($min = 0, $max = 1), //online,takeaway
            'order_store_id' =>  $this->faker->numberBetween($min = 1, $max = 1),
            'order_finalise_key' => $order_finalise_key

        ];
    }
}
