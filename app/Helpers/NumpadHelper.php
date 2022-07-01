<?php
namespace App\Helpers;

class NumpadHelper{


    public static function Numpad(){
        return [ 

       
            [ "%",".", "=", "/"],
            [ "7", "8", "9", "*" ],
            [ "4", "5", "6", "-" ],
            [ "1", "2", "3", "+" ],
            [ "0", "00", "ABC", "Back"] 
        ];
    }

    public static function Keypad(){
        return [ 

            "0" => [

                        [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "0" ],
                        [ "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P" ], 
                        [ "A", "S", "D", "F", "G", "H", "J", "K", "L", "Enter" ], 
                        [ "Z", "X", "C", "V", "B", "N", "M" ],
                        [ "Shift", "Aa", "Space", "123", "Back" ]

            ],
            "1" => [

                    [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "0" ],
                    [ "q", "w", "e", "r", "t", "y", "u", "i", "o", "p" ], 
                    [ "a", "s", "d", "f", "g", "h", "j", "k", "l" ], 
                    [ "z", "x", "c", "v", "b", "n", "m" ],
                    [ "Shift", "", "Space", "Back" ]

            ]

            

           
        ];
    }

   

  
}