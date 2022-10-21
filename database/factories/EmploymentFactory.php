<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Helpers\ConfigHelper;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class EmploymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        for ($i = 0; $i < 44; $i++) {
            $function[$i + 1] = $i;
        }

        foreach (ConfigHelper::EmploymentFunction() as $key => $value) {
            $employment_function[$key] = $this->faker->shuffle($function);
        }

        for ($i = 0; $i < 11; $i++) {
            $mode[$i + 1] = $i;
        }

        foreach (ConfigHelper::EmploymentMode() as $key => $value) {
            $employment_mode[$key] = $this->faker->shuffle($mode);
        }

        for ($i = 0; $i < 2; $i++) {
            $job[$i + 1] = $i;
        }

        foreach (ConfigHelper::EmploymentEmployeeJob() as $key => $value) {
            $employment_job[$key] = $this->faker->shuffle($job);
        }

        for ($i = 0; $i < 15; $i++) {
            $user_control[$i + 1] = $i;
        }

        foreach (ConfigHelper::EmploymentUserControl() as $key => $value) {
            $employment_user_control[$key] = $this->faker->shuffle($user_control);
        }

        $array = array_merge($employment_function, $employment_mode, $employment_job, $employment_user_control);

        return [
            'employment_user_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'employment_general' => [
                'ibutton' => $this->faker->numerify('##########'),
                'secret_number' => $this->faker->numberBetween($min = 1, $max = 100),
                'ni_number' => '',
            ],
            'employment_level_default' => [
                'default_menu_level' => $this->faker->numberBetween($min = 0, $max = 1), // drink, food, etc.
                'default_price_level' => $this->faker->numberBetween($min = 0, $max = 5),
                'default_floorplan_level' => $this->faker->numberBetween($min = 0, $max = 5),
            ],
            'employment_commision' => [
                'rate_1' => $this->faker->numberBetween($min = 1, $max = 100),
                'rate_2' => $this->faker->numberBetween($min = 1, $max = 100),
                'rate_3' => $this->faker->numberBetween($min = 1, $max = 100),
                'rate_4' => $this->faker->numberBetween($min = 1, $max = 100),
            ],
            'employment_setup' => $array,
            'employment_user_pay' => [
                'pay_rate' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 20),
                'from_date' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years', $timezone = null),
                'to_date' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = '-1 years', $timezone = null),
                'start_hour' => $this->faker->numberBetween($min = 0, $max = 24),
                'end_hour' => $this->faker->numberBetween($min = 0, $max = 24),
            ],
        ];
    }
}
