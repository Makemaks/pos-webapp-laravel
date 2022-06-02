<?php
namespace App\Helpers;
use App;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\LanguageHelper;

use Illuminate\Support\Arr;

class CountryHelper{



    public static function List() { 

        /* if ($request->session()->has('countryList')) {
                    $this->countryList =  $request->session()->get('countryList');
                }else{
                    $countryList = Http::get('https://restcountries.eu/rest/v2/all')->json();
                    $request->session()->put('countryList', $countryList);

                    $this->countryList = $countryList;
                } */
    } //

}


