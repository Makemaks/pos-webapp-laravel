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
            'person_firstname' => $this->faker->firstName('male'|'female'),
            'person_lastname' => $this->faker->lastname,
            'person_preferred_name' => $this->faker->randomElement($array = array (NULL,$this->faker->firstName('male'|'female'))),
        ];

        $person_phone = [
            "1" => $this->faker->randomElement($array = array (NULL,$this->faker->phoneNumber))
        ];

        $person_email = [
            "1" => $this->faker->randomElement($array = array (NULL,$this->faker->safeEmail))
        ];

        for ($i=0; $i < 10; $i++) { 
            $person_contact_user_id[$i+1] = $this->faker->numberBetween($min=1, $max=10);
        }

        for ($i=0; $i < 10; $i++) { 
            $person_message_group[$i+1] = $this->faker->word;
        }

        for ($i=0; $i < 10; $i++) { 
            $person_message_notification[] = [
                'person_user_id' => $this->faker->numberBetween($min=1, $max=10),
                'person_message_group' => $this->faker->numberBetween($min=0, $max=10)
            ];
        }

        

        
      
  
        return [
            //
            'person_message_notification' => $person_message_notification,
            'person_message_group' => $person_message_group,
            'person_type' => $this->faker->numberBetween($min=0, $max=5),
            'person_name' => $person_name,
            'person_role' => $this->faker->word,
            'person_contact_user_id' => $person_contact_user_id,
            'person_status' => $this->faker->paragraph($nbSentences = 3, $variableNbSentences = true),      
            'person_phone' => $person_phone,
            'person_email' => $person_email,
            'persontable_id' => $this->faker->numberBetween($min=1, $max=10),
            'persontable_type' => $this->faker->randomElement($array = array ('Store','Company')),
            'person_user_id' => $this->faker->numberBetween($min=1, $max=1),
            'person_dob' =>  $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-3 years', $timezone = null),

        ];
    }
}
