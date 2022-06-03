<?php

namespace Database\Factories;

use App\Models\Address;
use App\Helpers\LanguageHelper;
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

        $address_line = [
            "1" => $this->faker->streetName, 
            "2" => $this->faker->randomElement($array = array ('',$this->faker->citySuffix)),
            "3" => $this->faker->randomElement($array = array ('',$this->faker->streetSuffix)),
        ];

        $address_email = [
            "1" => $this->faker->randomElement($array = array ('',$this->faker->safeEmail)),
            "2" => $this->faker->randomElement($array = array ('',$this->faker->safeEmail)),
        ];

        $address_phone = [
            "1" => $this->faker->phoneNumber,
            "2" => $this->faker->randomElement($array = array ('',$this->faker->phoneNumber)),
        ];

        $address_website = [
            "1" => $this->faker->domainName,
            "2" => $this->faker->randomElement($array = array ('',$this->faker->domainName)),         
            
        ];


        $address_geolocation = [
            "latitude" => $this->faker->latitude($min = -90, $max = 90),
            "longitude" => $this->faker->longitude($min = -180, $max = 180),         
            
        ];

       
        return [
        
           'address_line' => $address_line,
           'address_town' => $this->faker->city, 
           'address_county' => $this->faker->state,
           'address_postcode' => $this->faker->postcode,
           'address_country' => $this->faker->randomElement($array = LanguageHelper::CountryCodes()),
           'address_email' => $address_email,
           'address_phone' => $address_phone,
           'address_website' => $address_website,
           'address_delivery_type' => $this->faker->numberBetween($min=0, $max=1),
           'addresstable_id' => $this->faker->numberBetween($min=1, $max=100),
           'addresstable_type' => $this->faker->randomElement($array = array ('Person','Company')),
           'address_default' => $this->faker->numberBetween($min=0, $max=1),
           'address_geolocation' => $address_geolocation

        ];
    }
}
