<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reservation_user_id' => $this->faker->numberBetween($min = 1, $max = 5),
            'reservation_description' => $this->faker->randomElement($array = array ('',$this->faker->word)),
            'reservation_account_id' => $this->faker->numberBetween($min = 1, $max = 5),
            'reservation_quantity' => $this->faker->numberBetween($min = 1, $max = 5),
            'reservation_no_show_fee' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
            'reservation_upfront_payment' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
            'reservation_payment_id' => $this->faker->numberBetween($min = 1, $max = 5),
        ];
    }
}
