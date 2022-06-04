<?php

namespace Database\Factories;

use App\Helpers\ConfigHelper;
use App\Helpers\CountryHelper;
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
                'type' => $this->faker->numberBetween($min=1, $max=5),
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

            $setting_receipt[$i+1] = [
                "receipt header" => [ 
                    "The TESTING CLUB",
                    "Tel: 061 319SS66  VAT: GB3158927S",
                    "41-43 Chruch Street",
                    "Epsom KT17 4QW",
                ],
                "commercial message" => [ 
                    "The Club is Open 1000-2200 Daily",
                    "",
                    "",
                    "",
                ],
                "bottom message" => [ 
                    "Thank You For Your Custom",
                    "See You Soon",
                    "MERRY CHRISTMAS",
                    "www.theepsomclub.com",
                ],
                "report message" => [ 
                    "",
                    "",
                    "",
                    "",
                ],
                "sig strip" => [ 
                    "",
                    "",
                    "Employee / Manager RRsignature",
                    ".......................John",
                ],
                "vat number" => "VAT No : 787655678",
                "default" => $this->faker->numberBetween($min = 0, $max = 1)
            ];

            
    
            $setting_vat[$i+1] = [
                "name" => $this->faker->word,
                "rate" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                "default" => 1
            ];

            

            $setting_stock_tag_group[$i + 1] = [
                "name" => $this->faker->word
            ];

            $setting_stock_printer[] = $i + 1;

            $setting_stock_offer[$i + 1] = [
                "decimal" => [
                    "gain" => $this->faker->numberBetween($min = 1, $max = 500),
                    "collect" => $this->faker->numberBetween($min = 1, $max = 500),
                    'discount(%)' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                    "value" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                ],

                "date" => [
                    'end_date' => $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-3 years', $timezone = null)->format('Y-m-d H:i:s'),
                    'start_date' => $this->faker->dateTimeBetween($startDate = '-60 years', $endDate = '-3 years', $timezone = null)->format('Y-m-d H:i:s'),
                ],

                "default" => [
                    'is_default' => $this->faker->numberBetween($min = 0, $max = 1),
                    'exception' => []
                ],



                "integer" => [
                    "set_menu" => $this->faker->numberBetween($min = 1, $max = 5),
                    'quantity' => $this->faker->numberBetween($min = 1, $max = 200),
                ],

                "boolean" => [
                    'type' => $this->faker->numberBetween($min = 0, $max = 1), //voucher / mix and match
                    "status" =>  1,
                ],

                "string" => [
                    "name" => $this->faker->word,
                    'description' => $this->faker->word,
                    "code" => $this->faker->lexify,
                ]

            ];

            $setting_stock_set_menu[$i + 1] = [
                "name" => $this->faker->word
            ];

            $setting_stock_case_size[$i + 1] = [
                "description" => $this->faker->word,
                "size" => $this->faker->numberBetween($min = 50, $max = 9999),
                "default" => 1,
            ];
    
            
            $setting_stock_recipe[$i+1] = [
                "name" => $this->faker->sentence,
                "link" => $this->faker->randomElement($array = array (NULL,$this->faker->url)),
                "default" => 1,
            ];

            $a = $this->faker->numberBetween($min = 1, $max = 7);
            if ($a == 1) {
                $value =  $this->faker->randomElement($array = array(null, '5', '10', '20', '100'));
            } else {
                $value = null;
            }

            $setting_key[$i + 1] = [
                "type" => $this->faker->numberBetween($min = 0, $max = 1),
                "description" => $this->faker->sentence(),
                "value" => $value,
                "setting_key_type" => $this->faker->numberBetween($min = 1, $max = 7),
            ];
        }

        for ($i=0; $i < 20; $i++) { 
            $setting_stock_group[$i+1] = [
                "description"=> $this->faker->word,
                "code"=> $this->faker->numberBetween($min = 1111, $max = 9999),
                "type"=> $this->faker->numberBetween($min = 0, $max = 3) //category::group::plu::brand
            ];

          
        }

        $array = [
            "CASH",
            "CREDIT",
            "NO FUNCTION",
            "ACCOUNT",
            "EFT",
            "HOTEL_TRANSFER",
            "VOUCHER",
        ];

        for ($i = 0; $i < count($array); $i++) {
            $setting_key_type[$i + 1] = $array[$i];
        }

        for ($i=0; $i < count(ConfigHelper::Nutrition()); $i++) { 
            $stock_nutrition[$i + 1] = ConfigHelper::Nutrition()[$i]['name'];
        }

        for ($i = 0; $i < count(ConfigHelper::Allergen()); $i++) {
            $stock_allergen[$i + 1] = ConfigHelper::Allergen()[$i];
        }
    
        $setting_group = [
            'default_country' => $this->faker->numberBetween($min = 1, $max = count(CountryHelper::ISO()))
        ];


        return [
            'setting_store_id' => $this->faker->numberBetween($min = 1, $max = 10),

            'setting_api' => $setting_payment_gateway,
            'setting_pos' => $setting_pos,
            'setting_stock_group'  => $setting_stock_group,
           
           
            'setting_vat' => $setting_vat,

            'setting_stock_nutrition' => $stock_nutrition,
            'setting_stock_allergen' => $stock_allergen,
            'setting_stock_offer' => $setting_stock_offer,
            'setting_stock_set_menu' => $setting_stock_set_menu,

            'setting_stock_case_size' => $setting_stock_case_size,
            'setting_stock_recipe' => $setting_stock_recipe,
            'setting_receipt' => $setting_receipt,
            
            'setting_key' => $setting_key,
            'setting_key_type' => $setting_key_type,
            'setting_group' => $setting_group,

        ];
    }
}
