<?php


namespace Database\Factories;

use App\Helpers\KeyHelper;
use App\Models\Setting;
use App\Models\Order;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
       
        $order_setting_key = Null;
        $count = $this->faker->numberBetween($min = 1, $max = 5);

        for ($i= 0; $i < $count; $i++) { 
            
            $j = $this->faker->numberBetween($min = 0, $max = KeyHelper::Type());

            $order_setting_key[$i + 1] = [
                "setting_key_group"  => $this->faker->numberBetween($min = 0, $max = 4),
                "setting_key_type" => $this->faker->numberBetween( $min = 0, $max = count(KeyHelper::Type()[ $j ]) ), 
                "value" => $this->faker->randomElement($array = array(null, $this->faker->numberBetween($min = 1, $max = 200))),
                "name"=> $this->faker->word,
                "status" => $this->faker->numberBetween($min = 0, $max = 1),
                "description" => '',
                "image" => ''
            ];

        }

        $vat = $this->faker->randomElement($array = array (NULL, $this->faker->numberBetween($min = 1, $max = 3) ));
        $order_vat = Null;
        if ($vat) {
            for ($i = 0; $i < $vat; $i++) {
                $order_vat[$i + 1] = $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 10, $max = 20);
            }
        }

        return [
            'order_setting_pos_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'order_store_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'order_user_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'ordertable_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'ordertable_type' => $this->faker->randomElement($array = array( 'User', 'Company' )),
            'order_status' => $this->faker->numberBetween($min = 0, $max = 7),
            'order_type' => $this->faker->numberBetween($min = 0, $max = 1), //online,takeaway
            'order_setting_key' => $order_setting_key,
            'order_setting_vat' => $order_vat
        ];

    }
}
