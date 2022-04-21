<?php

namespace Database\Factories;
use App\Models\Stock;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        for ($i=0; $i < 6; $i++) { 

            $stock_cost[$i + 1] = [
                'amount' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 200000),
                'quantity' => $this->faker->numberBetween($min = 0, $max = 50),
                'cost_default' => $this->faker->numberBetween($min = 0, $max = 1),
            ];

            $stock_supplier[$i + 1] = [
                'ref' => $this->faker->numberBetween($min = 1, $max = 5),
                'code' => $this->faker->randomElement($array = array (NULL,$this->faker->numberBetween($min=20000, $max=50000))),
                'unit cost' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                'case cost' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
                'supplier_default' => $this->faker->numberBetween($min = 0, $max = 1),
            ];

            $stock_transfer[$i + 1] = [
                "store_id" => $this->faker->numberBetween($min = 1, $max = 50),
                "stock_id"=> $this->faker->numberBetween($min = 1, $max = 50),
                "user_id"=> $this->faker->numberBetween($min = 1, $max = 2),
                "price"=> $this->faker->randomElement($array = array (NULL,$this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50))),
                "quantity"=>  $this->faker->numberBetween($min = 1, $max = 50),
                "date"=> $this->faker->dateTimeBetween($startDate = '1 years', $endDate = '2 years', $timezone = null)->format('Y-m-d H:i:s'),
                "type" => $this->faker->numberBetween($min = 0, $max = 1),
            ];

            $stock_offers[$i + 1] = [
                "gain" => $this->faker->numberBetween($min = 1, $max = 500),
                "collect"=> $this->faker->numberBetween($min = 1, $max = 500),
                "offer_default" => $this->faker->numberBetween($min = 0, $max = 1),
            ];

            $stock_web[$i + 1] = [
                "plu" => $this->faker->numberBetween($min = 1, $max = 50), 	
                "min" => $this->faker->numberBetween($min = 1, $max = 50),
                "max" => $this->faker->numberBetween($min = 1, $max = 50),
                "price" => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 500),
                "default" => $this->faker->numberBetween($min = 0, $max = 1),
                "offer_id" => $this->faker->numberBetween($min = 1, $max = 5),
            ];

            $stock_nutrition[$i + 1] = [$i];
    
        }

        $stock_gross_profit = [
            'target' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
            'actual' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
            'rrp' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
            'average cost' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
        ];


        $stock_merchandise = [
            "non stock"=> "",
            "current stock"=> "",
            "minimum stock"=> "",
            "maximum stock"=> "",
            "days to order"=> "", 
            "master plu"=> "", 	
            "qty adjustment"=> "",
            "recipe link"=> "",
            "unit size"=> "",
            "case size"=> "",
            "outer barcode"=> "",
        ];
       
        for ($i=0; $i < 15 ; $i++) { 
            $flags[$i + 1] = $i;
        }
        $stock_termminal_flags = [
            'status flags' => $this->faker->shuffle($flags),
            'kitchen printers' => $this->faker->shuffle($flags),
            'commission rates' => $this->faker->shuffle($flags),
            'selective itemisers' => $this->faker->shuffle($flags),
            'stock control' => $this->faker->shuffle($flags)
        ];
           
      
        

        return [
            'stock_name' => $this->faker->word,
            'stock_description' => $this->faker->paragraph,
            'stock_barcode' => $this->faker->ean13, //barcode
            'stock_group_id' => $this->faker->numberBetween($min = 0, $max = 2),
            'stock_cost' => $stock_cost,
            'stock_quantity' => $this->faker->numberBetween($min = 1, $max = 200),
            'stock_supplier' => $stock_supplier,
            'stock_rrp' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 50),
            'stock_category_id' => $this->faker->numberBetween($min = 0, $max = 4),
            'stock_random_code' => $this->faker->randomElement($array = array (NULL,$this->faker->numberBetween($min=20000, $max=50000))),
            'stock_parent_id' => $this->faker->randomElement($array = array (NULL,$this->faker->numberBetween($min=1, $max=5))),
            'stock_store_id' => $this->faker->numberBetween($min = 1, $max = 10),
            'stock_alert_level' => $this->faker->numberBetween($min = 1, $max = 10),
            'stock_gross_profit' => $stock_gross_profit,
            'stock_offers' => $stock_offers,
            'stock_merchandise' => $stock_merchandise,
            'stock_transfer' => $stock_transfer,
            'stock_termminal_flags' => $stock_termminal_flags,
            'stock_web' => $stock_web,
            'stock_nutrition' => $stock_nutrition,
            'stock_allergen' => $stock_nutrition
        ];

    }
}
