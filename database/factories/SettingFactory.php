<?php

namespace Database\Factories;
use App\Helpers\ConfigHelper;
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

            $setting_stock_printer[] = $i+1;

        }


        return [
            'setting_store_id' => $this->faker->numberBetween($min = 1, $max = 10),
            
            'setting_payment_gateway' => $setting_payment_gateway,
            'setting_pos' => $setting_pos,
            
            'setting_stock_voucher' => $setting_stock_voucher,

            'setting_stock_group_category_plu'  => $setting_stock_group_category_plu,
            'setting_mix_match' => $setting_mix_match,
           
     
        ];
    }
}
