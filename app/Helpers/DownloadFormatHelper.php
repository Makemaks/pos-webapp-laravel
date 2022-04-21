<?php
namespace App\Helpers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use League\Csv\Writer;
use SplTempFileObject;

//https://csv.thephpleague.com/8.0/installation/

class DownloadFormatHelper{


    public static function CSV($array, $column, $row)
    {
 
        $csv = Writer::createFromFileObject(new SplTempFileObject());
       
        foreach ($array as $arrayItem => $arrayValue) {          
           
            $rowArray[] = $arrayValue->$column;
            $rowArray[] = '';
            $rowArray[] = $arrayValue->$row;
          
        
            $csv->insertOne($rowArray);
        }
       
        $csv->output('survey.csv');
       
    }



        


  

}