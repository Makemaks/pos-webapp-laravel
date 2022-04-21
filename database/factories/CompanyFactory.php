<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'company_store_id' => $this->faker->numberBetween($min=1, $max=10),
            'company_name' => $this->faker->company,
            'company_type'=> $this->faker->numberBetween($min=0, $max=2), //supplier, customer, contractor
            'parent_company_id' => $this->faker->randomElement($array = array (NULL,$this->faker->numberBetween($min=1, $max=100))),
        ];
    }
}
