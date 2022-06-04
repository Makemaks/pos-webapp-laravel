<?php
namespace App\Helpers;
use App;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Helpers\CountryHelper;
use Illuminate\Support\Arr;

class CurrencyHelper{


    public static function Format($number, $decimal = 1) { // cents: 0=never, 1=if needed, 2=always

        if (is_numeric($number)) { // a number
            if (!$number) { // zero
            $money = ($decimal == 2 ? '0.00' : '0.00'); // output zero
            } else { // value
            if (floor($number) == $number) { // whole number
                $money = number_format($number, ($decimal == 2 ? 2 : 2)); // format
            } else { // cents
                $money = number_format(round($number, 2), ($decimal == 0 ? 0 : 2)); // format
            } // integer or decimal
            } // value
            return $money;
        } // numeric
    } //

}


