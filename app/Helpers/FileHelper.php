<?php
namespace App\Helpers;

class FileHelper{


    //phpspreadsheet
    public static function Csv($inputFileName){
        //$inputFileName = './sampleData/example1.xls';

        /**  Identify the type of $inputFileName  **/
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);

        return $spreadsheet;
    }

   


  
}