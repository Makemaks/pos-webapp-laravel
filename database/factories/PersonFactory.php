<?php

namespace Database\Factories;

use App\Models\Person;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $person_name = [
            'person_firstname' => $this->faker->firstName('male' | 'female'),
            'person_lastname' => $this->faker->lastname,
            'person_preferred_name' => $this->faker->randomElement($array = array(NULL, $this->faker->firstName('male' | 'female'))),
        ];

        $person_phone = [
            "1" => $this->faker->randomElement($array = array(NULL, $this->faker->phoneNumber))
        ];

        $person_email = [
            "1" => $this->faker->randomElement($array = array(NULL, $this->faker->safeEmail))
        ];



        for ($i = 0; $i < 10; $i++) {
            $person_message_group[$i + 1] = $this->faker->word;
        }

        for ($i = 0; $i < 10; $i++) {
            $person_message_notification[] = [
                'person_user_id' => $this->faker->numberBetween($min = 1, $max = 10),
                'person_message_group' => $this->faker->numberBetween($min = 0, $max = 10)
            ];
        }

        $person_stock_cost = null;
        $count = $this->faker->randomElement($array = array (NULL, $this->faker->numberBetween($min = 1, $max = 1) ));
        if ($count) {
            for ($i = 0; $i < $count; $i++) {
                $person_stock_cost[$i+1] = [
                    'column' => $this->faker->numberBetween($min = 1, $max = 5),
                    'row' => $this->faker->numberBetween($min = 5, $max = 10)
                ];
            }
        }

        //type
        $person_offer[$i + 1] = [
            "decimal" => [
                    "gain" => $this->faker->numberBetween($min = 1, $max = 500),
                    "collect" => $this->faker->numberBetween($min = 1, $max = 500),
                    "discount_type" => $this->faker->numberBetween($min = 0, $max = 1),
                    "discount_value" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 1, $max = 5),
            ],

            "date" => [
                "start_date" => $this->faker->dateTimeBetween($startDate = '1 years', $endDate = '2 years', $timezone = null)->format('Y-m-d H:i:s'),
                "end_date" => $this->faker->dateTimeBetween($startDate = '3 years', $endDate = '4 years', $timezone = null)->format('Y-m-d H:i:s'),
               
            ],

            "integer" => [
                "set_menu" => $this->faker->numberBetween($min = 1, $max = 5),
                "quantity" => $this->faker->numberBetween($min = 1, $max = 200),
                "stock_cost" => $this->faker->randomElement($array = array(null, $this->faker->numberBetween($min = 1, $max = 200))),
            ],

            "boolean" => [
                "type" => $this->faker->numberBetween($min = 0, $max = 1), //voucher / mix and match
                "status" =>  1,
                "prompt" => $this->faker->numberBetween($min = 0, $max = 1)
            ],

            "string" => [
                "name" => $this->faker->word,
                "description" => $this->faker->word,
                "code" => $this->faker->lexify,
            ],
            "available_day" => $this->faker->randomElements($array = array ('1','2','3', '4', '5', '6', '7'), $count = $this->faker->numberBetween($min = 1, $max = 7)),

        ];



        return [
            //
            'person_message_notification' => $person_message_notification,
            'person_message_group' => $person_message_group,
            'person_type' => $this->faker->numberBetween($min = 0, $max = 2),
            'person_name' => $person_name,
            'person_role' => $this->faker->word,

            'person_phone' => $person_phone,
            'person_email' => $person_email,
            'persontable_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'persontable_type' => $this->faker->randomElement($array = array('Store', 'Company')),
            'person_user_id' => $this->faker->numberBetween($min = 1, $max = 1),
            'person_dob' =>  $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-3 years', $timezone = null),
            'person_stock_cost' => $person_stock_cost,
            'person_offer' => $person_offer,
            'person_credit' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 1, $max = 500),
        ];
    }
}
