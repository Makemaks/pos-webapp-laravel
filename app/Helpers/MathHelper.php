<?php
namespace App\Helpers;

class MathHelper{


    public static function FloatRoundUp(float $float, int $decimalPlace){
        return round($float, $decimalPlace);
    }

    public static function StripeRoundUp(float $float){
        $amount = ($float * 100);
        return $amount;
    }

    public static function VAT(float $vat, float $price){
        $vatToPay = ($vat / 100) * $price;
        return $price + $vatToPay;
    }


    public static function Discount(float $discount, float $price){
        $discount = ($discount / 100) * $price;
        return $price - $discount;
    }

    public static function PercentageDifference(float $valueA, float $valueB){
        $percentage = ($valueA / $valueB) * 100;
        return $percentage;
    }


  
}