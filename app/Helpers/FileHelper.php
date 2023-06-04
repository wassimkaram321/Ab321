<?php
namespace App\Helpers;
class FileHelper
{
    public static function addFile($image , $path = null){

        $file_extension = $image->getClientOriginalExtension();
        $file_name = time() . '.' . $file_extension;
        $image->move('images', $file_name);
        $image = $file_name;
        return $file_name;
    }
    public static function getFileName($file){

 
        return $file->getClientOriginalName();
    }
}
