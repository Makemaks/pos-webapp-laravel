<?php
namespace App\Helpers;

class NumpadHelper{


    public static function Numpad(){
        return [ 

       
            [ "%",".", "=", "/"],
            [ "7", "8", "9", "*" ],
            [ "4", "5", "6", "-" ],
            [ "1", "2", "3", "+" ],
            [ "0", "00", "Enter", "Back"] 
        ];
    }

    public static function Lockpad(){
        return [ 

            [ "7", "8", "9"],
            [ "4", "5", "6"],
            [ "1", "2", "3"],
            [ "0", "Back", ""] 
        ];
    }

    public static function Keypad(){
        return [ 

            "0" => [

                        [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "0" ],
                        [ "Q", "W", "E", "R", "T", "Y", "U", "I", "O", "P" ], 
                        [ "A", "S", "D", "F", "G", "H", "J", "K", "L", "Back"], 
                        [ "Shift", "Z", "X", "C", "V", "B", "N", "M", "Shift" ],
                        [ "Aa", "fn" ,"Space", "fn", "Enter"]

            ],
            "1" => [

                    [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "0" ],
                    [ "q", "w", "e", "r", "t", "y", "u", "i", "o", "p" ], 
                    [ "a", "s", "d", "f", "g", "h", "j", "k", "l", "Back"  ], 
                    [ "Shift","z", "x", "c", "v", "b", "n", "m", "Shift" ],
                    [ "Aa", "fn" ,"Space", "fn", "Enter" ]

            ],

            "2" => [

                    [ "!", "@", "£", "$", "%", "^", "&", "*", "(", ")" ],
                    [ "-", "=", "[", "]", ";", "'", "\'", ",", ".", "/" ], 
                    [ "{", "}", ":", "\"", "'|", "<", ">", "?", "~", "`" ], 
                    [ "Shift", "Back" ],
                    [ "Aa", "fn" ,"Space", "fn" ,"Enter" ]

            ]

           
        ];
    }

   

  
}