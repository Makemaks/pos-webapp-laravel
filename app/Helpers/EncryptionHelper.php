<?php

namespace App\Helpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class EncryptionHelper{

  
  
    public static function Encrypt($key) {

        return Crypt::encrypt($key);      
    }

  
   public static function Decrypt($key) {
      
        return  Crypt::decrypt($key);
        
    }

    
}

