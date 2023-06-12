<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class FileHelper
{
    public static function addFile($image, $path = 'images')
    {

        $file_extension = $image->getClientOriginalExtension();
        $file_name = rand(1, 100) . time() . '.' . $file_extension;
        $image->move($path, $file_name);
        $image = $file_name;
        return $file_name;
    }
    public static function getFileName($file)
    {


        return $file->getClientOriginalName();
    }
    public static function deleteFile($image, $path = 'images')
    { {

        $imageName = basename($image);

        $imagePath = public_path('images/categories/' . $imageName);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

            return true;
        }
    }
}
