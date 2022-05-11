<?php
namespace App\Helpers;

class MathHelper{


    public static function FloatRoundUp(float $float, int $decimalPlace){
        return round($float, $decimalPlace);
    }

    public static function VAT(float $vat, float $price){
        $vatToPay = ($vat / 100) * $price;
        return $price + $vatToPay;
    }


    public static function Discount(float $discount, float $price){
        $discount = ($discount / 100) * $price;
        return $price - $discount;
    }
  
}