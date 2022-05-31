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
            'address_line' => [
                'address_line_1' => $this->faker->streetAddress,
                'address_line_2' => $this->faker->streetAddress,
                'address_line_3' => $this->faker->streetAddress,
                'address_town' => $this->faker->city,
                'address_county' => $this->faker->state,
                'address_postcode' => $this->faker->postcode,
                'address_country' => $this->faker->country,
            ],
            'address_email' => [
                'address_email_1' => $this->faker->safeEmail,
                'address_email_2' => $this->faker->safeEmail,
            ],
            'address_phone' => [
                'address_phone_1' => $this->faker->phoneNumber,
                'address_phone_2' => $this->faker->phoneNumber,
            ],
            'address_website' => [
                'address_website_1' => $this->faker->domainName,
                'address_website_2' => $this->faker->domainName,
            ],
            'address_coordinate' => [
                'latitude' => $this->faker->latitude,
                'longitude' => $this->faker->longitude,
            ],
            'address_type' => $this->faker->numberBetween($min = 0, $max = 1),
            'address_delivery_type' => $this->faker->numberBetween($min = 0, $max = 1),
            'addresstable_id' => $this->faker->numberBetween($min = 1, $max = 100),
            'addresstable_type' => $this->faker->randomElement($array = array('Person', 'Company')),
        ];
    }
}
