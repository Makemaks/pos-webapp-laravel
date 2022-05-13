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
        return [
            'order_user_id' => $this->faker->numberBetween($min=1, $max=2),
            'order_status' => $this->faker->numberBetween($min = 0, $max = 7),
            'order_type' => $this->faker->numberBetween($min = 0, $max = 1), //online,takeaway
            'order_store_id' =>  $this->faker->numberBetween($min=1, $max=1),
        ];
    }
}
