<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_account_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'user_person_id' => $this->faker->unique(true)->numberBetween(1, 10),
            'user_type' => $this->faker->numberBetween($min = 0, $max = 3),
            'user_is_disabled' => 0,
            'user_is_notifiable' => 1,
            'email' => $this->faker->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('test1234'), // password
            'remember_token' => Str::random(10),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
