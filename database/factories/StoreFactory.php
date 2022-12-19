<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'store_image' => '',
            'store_name' => $this->faker->word,
            'root_store_id'=> $this->faker->numberBetween($min = 1, $max = 10),
            'store_account_id'=> $this->faker->numberBetween($min = 1, $max = 10),
            'store_company_id'=> $this->faker->numberBetween($min = 1, $max = 10),
        ];
    }
}
