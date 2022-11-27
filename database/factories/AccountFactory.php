<?php

namespace Database\Factories;

use App\Models\Account;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $accountable_type = $this->faker->randomElement($array = array('Person', 'Company'));

        if ($accountable_type == 'Company') {
            $account_type = 1;
        } else if ($accountable_type == 'Person') {
            $account_type = 2;
        } else {
            $account_type = 0;
        }
        for ($i=0; $i < 2; $i++) { 
            $account_blacklist[$i+1] = [
                "type" => $this->faker->numberBetween($min = 0, $max = 1),
                "description" => $this->faker->word,
                "start_time" => "",
                "end_time" => "",
                "user_id" => "",
                "blocked_access" => []
            ];
        }


        return [
            'account_system_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'accountable_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'accountable_type' => $accountable_type,
            'account_type' => $account_type,
            'account_description' => $this->faker->sentence,
            'account_blacklist' => $this->faker->randomElement($array = array(NULL, $account_blacklist))
        ];
    }
}
