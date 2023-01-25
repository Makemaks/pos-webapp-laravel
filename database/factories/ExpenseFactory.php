<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            'expense_user_id' => $this->faker->numberBetween($min=1, $max=10),
            'expense_name' => $this->faker->sentence,
           
            'expense_amount' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 2000),
            'expense_frequency' =>  $this->faker->randomElement($array = array (NULL,$this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50))),
            'expense_frequency_period_id' =>  $this->faker->randomElement($array = array (NULL,$this->faker->numberBetween($min=1, $max=100))),
            
            'expense_setting_expense_type' =>  $this->faker->numberBetween($min=1, $max=5),

        ];
    }
}
