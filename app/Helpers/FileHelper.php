<?php
namespace App\Helpers;
class FileHelper
{
    public static function addFile($image , $path = 'images'){

        $file_extension = $image->getClientOriginalExtension();
        $file_name = rand(1,100).time() . '.' . $file_extension;
        $image->move($path, $file_name);
        $image = $file_name;
        return $file_name;
    }
    public static function getFileName($file){


        return $file->getClientOriginalName();
    }
}
