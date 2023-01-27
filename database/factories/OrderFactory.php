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
        $countType = count(KeyHelper::Type());
        $count = $this->faker->numberBetween($min = 0, $max = $countType -1 );

        for ($i= 0; $i < $count; $i++) {

            $j = $this->faker->numberBetween( $min = 0, $max = count(KeyHelper::Type()[$i])-1 );

            $order_setting_key[$i + 1] = [
                "setting_key_group"  => $i,
                "setting_key_type" => $j,
                "value" => $this->faker->randomElement($array = array(null, $this->faker->numberBetween($min = 1, $max = 200))),
                "name"=> $this->faker->word,
                "status" => $this->faker->numberBetween($min = 0, $max = 1),
                "description" => '',
                "image" => ''
            ];

        }

        
        for ($i=0; $i < $this->faker->numberBetween($min = 1, $max = 5); $i++) { 
            $order_setting_vat[$i+1] = [
                "name" => $this->faker->word,
                "rate" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 20),
                "default" => $this->faker->numberBetween($min = 0, $max = 1)
            ];
        }

        return [
            'order_setting_pos_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'order_store_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'order_user_id' => $this->faker->numberBetween($min = 1, $max = 2),
            'order_account_id' => $this->faker->numberBetween($min = 1, $max = 10),
           
            'order_status' => $this->faker->numberBetween($min = 0, $max = 7),
            'order_type' => $this->faker->numberBetween($min = 0, $max = 1), //online,takeaway
            'order_setting_key' => $order_setting_key,
            'order_setting_vat' => $order_setting_vat
        ];

    }
}
