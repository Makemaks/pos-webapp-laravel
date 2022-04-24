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

            $setting_mix_match[$i+1] = [
                'Descriptor' => $this->faker->word,
                'Amount / Discount Rate(%)' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                'Quantity Required' => $this->faker->numberBetween($min = 1, $max = 200),
                'Mix & Match Type' => '',
                'Start Date' => $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-3 years', $timezone = null),
                'End Time' => $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-3 years', $timezone = null),
            ];

            $setting_stock_voucher[$i+1] = [
                "number" => $this->faker->lexify,
                "store_id" => $this->faker->numberBetween($min = 1, $max = 200),
                "name" => $this->faker->word,
                "value" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                "expiry_date" => $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-3 years', $timezone = null),
                "status" =>  $this->faker->numberBetween($min = 0, $max = 1),
                "type" =>  $this->faker->numberBetween($min = 0, $max = 1), //discount or gift card
                "quantity" =>  $this->faker->numberBetween($min = 200, $max = 1000),
            ];
        
            $setting_receipt[$i+1] = [
                "receipt header" => [ 1 => $this->faker->word],
                "commercial message" => [ 1 => $this->faker->paragraph],
                "bottom message" => [ 1 => $this->faker->paragraph],
                "report message" => [ 1 => $this->faker->paragraph],
                "sig strip" => [ 1 => $this->faker->word],
                "vat number" => [ 1 => $this->faker->numberBetween($min = 1111, $max = 9999)],
                "default" => [ 1 => $this->faker->numberBetween($min = 0, $max = 1)]
            ];

            $setting_reason[$i+1] = [
                "name" => $this->faker->word,
                "setting_stock_group_category_plu_id" => $this->faker->numberBetween($min = 1, $max = 50)
            ];
    
            $setting_vat[$i+1] = [
                "name" => $this->faker->word,
                "rate" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                "active" => $this->faker->numberBetween($min = 0, $max = 1)
            ];

            $setting_stock_group_category_plu[$i+1] = [
                "descriptor"=> $this->faker->word,
                "code"=> $this->faker->numberBetween($min = 1111, $max = 9999),
                "type"=> $this->faker->numberBetween($min = 0, $max = 2)
            ];

            $setting_stock_tag_group[$i+1] =[
                "name" => [$this->faker->word]
            ];

        }

            $setting_stock_nutrition = [
                'Energy',
                'Fat', 	
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
       

        $setting_stock_label = [

            'SHELF' => [
                "DEFAULT TEMPLATES" => [
                    "A4" => "A4 (24 labels [3x8], 60x30mm) - 210mm x 297mm",
                    "A4 SPAR" => "A4 SPAR (24 labels [3x8], 67.5x34mm) - 210mm x 297mm",
                    "EU30016WX" => "EU30016WX (24 labels [3x8], 63.5 x 33.9mm) - 210mm x 297mm",
                    "SECC21LCE" => "SECC21LCE (21 labels [3x7], 70 x 37.5mm) - 210mm x 297mm",
                    "SRP-770II 38x25" => "SRP-770II 38x25 (BIXILON Single label roll, 38 x 25mm) - 38mm x 25mm",
                    "SRP-770II 45x35" => "SRP-770II 45x35 (BIXILON Single label roll, 45 x 35mm) - 45mm x 35mm",
                    "DA402 80x38" => "DA402 80x38 (ZEBRA Single label roll, 80 x 38mm) - 80mm x 38mm",
                    "DK-1201" => "DK-1201 (Single label roll, 90 x 29mm) - 90mm x 29mm",
                    "GK420t" => "GK420t (Single label feed, 48.5 x 35mm) - 49mm x 35mm",
                    "A4 (Allergens)" => "A4 (Allergens) (8 labels [1x8], 120x30mm) - 210mm x 297mm",
                    "A4 (Alternative Text)" => "A4 (Alternative Text) (24 labels [3x8], 60x30mm) - 210mm x 297mm",
    
                ],
    
                "CUSTOM TEMPLATES" => [
                    
                ],
            ],
    
            'STOCK' => [
                "DEFAULT TEMPLATES" => [
                    "DK-1201" => "DK-1201 - 90mm x 29mm",
                    "DK-22210" => "DK-22210 - 100mm x 29mm",
                    "DK-11204" => "DK-11204 - 54mm x 17mm",
                    "SLP-MRL" =>"SLP-MRL - 51mm x 28mm",
                    "SRP-770II 38x25" => "SRP-770II 38x25 - 38mm x 25mm",
                    "SRP-770II 45x35" => "SRP-770II 45x35 - 45mm x 35mm",
                    "DK-1201 (Allergens)" => "DK-1201 (Allergens) - 90mm x 29mm",
                    "DK-1201 (Alternative Text)" => "DK-1201 (Alternative Text) - 90mm x 29mm",
                ],
    
                "CUSTOM TEMPLATES" => [
                    
                ],
               
            ],
        ];
        
        
        

        return [
            'setting_store_id' => $this->faker->numberBetween($min = 1, $max = 10),
            
            'setting_payment_gateway' => $setting_payment_gateway,
            'setting_pos' => $setting_pos,

            'setting_stock_nutrition' => $setting_stock_nutrition,
            'setting_stock_allergen' => $setting_stock_allergen,
            'setting_printer' => $setting_printer,
            //'setting_stock_rate' => $setting_stock_rate
            'setting_stock_label' => $setting_stock_label,
            'setting_stock_voucher' => $setting_stock_voucher,

            'setting_stock_group_category_plu'  => $setting_stock_group_category_plu,
            'setting_mix_match' => $setting_mix_match,

            
            

     
        ];
    }
}
