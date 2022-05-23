<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\ConfigHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class EmployementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        foreach (ConfigHelper::EmployementFunction() as $key => $value) {
            $employement_function[$value] = $this->faker->numberBetween($min = 0, $max = 1);
        }

        foreach (ConfigHelper::EmployementMode() as $key => $value) {
            $employement_mode[$value] = $this->faker->numberBetween($min = 0, $max = 1);
        }
        foreach (ConfigHelper::EmployementEmployeeJob() as $key => $value) {
            $employement_employee_job[$value] = $this->faker->numberBetween($min = 0, $max = 1);
        }

        foreach (ConfigHelper::EmployementUserControl() as $key => $value) {
            $employment_user_control[$value] = $this->faker->numberBetween($min = 0, $max = 1);
        }

        return [
            'employement_user_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'employement_general' => [
                'ibutton' => $this->faker->numerify('##########'),
                'secret_number' => $this->faker->numberBetween($min = 1, $max = 100),
                'ni_number' => '',
            ],
            'employement_level_default' => [
                'default_menu_level' => $this->faker->numberBetween($min = 0, $max = 1), // drink, food, etc.
                'default_price_level' => $this->faker->numberBetween($min = 0, $max = 5),
                'default_floorplan_level' => $this->faker->numberBetween($min = 0, $max = 5),
            ],
            'employement_commision' => [
                '1' => $this->faker->numberBetween($min = 1, $max = 100),
                '2' => $this->faker->numberBetween($min = 1, $max = 100),
                '3' => $this->faker->numberBetween($min = 1, $max = 100),
                '4' => $this->faker->numberBetween($min = 1, $max = 100),
            ],
            'employement_allowed_function' => $employement_function,
            'employement_allowed_mode' => $employement_mode,
            'employement_employee_job' => $employement_employee_job,
            'employement_user_control' => $employment_user_control,
            'employement_user_pay' => [
                'pay_rate' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 200000),
                'from_date' => now()->subDays(30)->format('Y-m-d'),
                'to_date' => now()->format('Y-m-d'),
                'start_hour' => $this->faker->numberBetween($min = 0, $max = 24),
                'end_hour' => $this->faker->numberBetween($min = 0, $max = 24),
            ],
        ];
    }
}
