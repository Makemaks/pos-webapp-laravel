<?php

namespace Database\Factories;
use App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $setting_payment_gateway = [
            [   
                'name' => 'stripe', 
                'key' => 'pk_test_51IT1oKIsAyzPkVnu6KvDEOeNtomWeqwyet5eQ54q0rRYfnAVwOuwGCDPto5LGzIPzRQmL5bKzFExUivkWqBP3pVx00kyCqcZh4', 
                'secret' => 'sk_test_51IT1oKIsAyzPkVnuXXLmnfXAgSX5G54u4lnyVFyOjp3pTvruMvEeSN3vl09t3PaGURWcdAEAw7krPIY9wVSncvew004DzmhzPK'
            ],
        ];

      

        for ($i=0; $i < 5; $i++) { 
            $setting_pos[$i+1] = [
                "name"=>$this->faker->word,
                "cash"=>['quantity' => $this->faker->numberBetween($min=1, $max=100), 'amount' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 500)],
                "credit"=>['quantity' => $this->faker->numberBetween($min=1, $max=100), 'amount' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 500)]
            ]; 

            $setting_printer[$i+1] = [
                $this->faker->numberBetween($min=1, $max=100)
            ]; 

            $setting_stock_itemisers[$i+1] = [
                $this->faker->numberBetween($min=1, $max=100)
            ]; 
        }

        $setting_stock_nutrition = [
            'Energy','Fat', 	
            'Saturate', 
            'Carbohydrate', 
            'Sugar', 	
            'Protein', 	
            'Salt', 
            'Portions' 
        ];


        $setting_stock_allergen = [
            'Celery',
            'Cereals Containing Gluten',
            'Crustaceans',
            'Eggs',
            'Fish',
            'Lupin',
            'Milk',
            'Molluscs',
            'Mustard',
            'Tree Nuts',
            'Peanuts',
            'Sesame Seeds',
            'Soyabeans',
            'Sulphur Dioxide and Sulphites',
            'Allergen 15',
            'Allergen 16',
        ];
        

        return [
            'setting_store_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'setting_payment_gateway' => $setting_payment_gateway,
            'setting_pos' => $setting_pos,

            'setting_stock_nutrition' => $setting_stock_nutrition,
            'setting_stock_allergen' => $setting_stock_allergen,
            'setting_printer' => $setting_printer,
            //'setting_stock_rate' => $setting_stock_rate
        ];
    }
}
