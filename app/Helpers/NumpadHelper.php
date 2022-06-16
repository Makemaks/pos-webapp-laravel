<?php
namespace App\Helpers;

class NumpadHelper{


    public static function Numpad(){
        return [ 

            "0" => [

                        [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "0" ],
                        [ "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P" ], 
                        [ "A", "S", "D", "F", "G", "H", "J", "K", "L" ], 
                        [ "Z", "X", "C", "V", "B", "N", "M" ],
                        [ "Shift", "", "Space", "Back" ]

            ],
            "1" => [

                    [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "0" ],
                    [ "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P" ], 
                    [ "A", "S", "D", "F", "G", "H", "J", "K", "L" ], 
                    [ "Z", "X", "C", "V", "B", "N", "M" ],
                    [ "Shift", "", "Space", "Back" ]

            ]

            

           
        ];
    }

   

  
}