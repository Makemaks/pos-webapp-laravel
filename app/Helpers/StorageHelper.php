<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StorageHelper
{
   
    
    private static $DEFAULT_IMAGE_LINK = 'public/images/';
    private static $DEFAULT_VIDEO_LINK = 'public/videos/';
  
    private static $IS_AVATAR = 1;

    private static $DEFAULT_FILES = 'public/image';

    public static function ImageLink(){
        return SELF::$DEFAULT_IMAGE_LINK;
    }

    public static function VideoLink(){
        return SELF::$DEFAULT_VIDEO_LINK;
    }

    public static function AvatarLink(){
        return SELF::$DEFAULT_IMAGE_LINK;
    }

    public static function Get(int $user_id){
     
        $fileList = Storage::files(SELF::$DEFAULT_FILES);


        $galleryList = DB::table('gallery')
        ->where([
            ['id', '=', $user_id],
            ['gallery_type', '=', 'Image']
            ])
        ->get();

      

        return $galleryList;
    }

    public static function GalleryList(int $user_id){
     
        $fileList = Storage::files(SELF::$DEFAULT_FILES);


        $galleryList = DB::table('gallery')
        ->where([
            ['id', '=', $user_id],
            ['gallery_type', '=', 'Image']
            ])
        ->get();

      

        return $galleryList;
    }

}

  
