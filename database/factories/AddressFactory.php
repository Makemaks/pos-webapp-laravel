<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

        
           'address_line_1' => $this->faker->streetName, 
           'address_line_2' => $this->faker->randomElement($array = array ('',$this->faker->citySuffix)),
           'address_line_3' => $this->faker->randomElement($array = array ('',$this->faker->streetSuffix)),
           'address_town' => $this->faker->city, 
           'address_county' => $this->faker->state,
           'address_postcode' => $this->faker->postcode,
           'address_country' => $this->faker->country,
           'address_email_1' => $this->faker->safeEmail,
           'address_email_2' => $this->faker->randomElement($array = array ('',$this->faker->safeEmail)),
           'address_phone_1' => $this->faker->phoneNumber,
           'address_phone_2' => $this->faker->randomElement($array = array ('',$this->faker->phoneNumber)),
           'address_website_1' => $this->faker->domainName,
           'address_website_2' => $this->faker->randomElement($array = array ('',$this->faker->domainName)),         
           'address_type' => $this->faker->numberBetween($min=0, $max=1),
           'address_delivery_type' => $this->faker->numberBetween($min=0, $max=1),
           'addresstable_id' => $this->faker->numberBetween($min=1, $max=100),
           'addresstable_type' => $this->faker->randomElement($array = array ('Person','Company')),

        ];
    }
}
