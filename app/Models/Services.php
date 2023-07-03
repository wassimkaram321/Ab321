<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $fillable = ['title','title_ar','content','content_ar','icon'];
    public static function booted()
    {
        static::retrieved(function ($services) {
            if(isset($services->icon))
                $services->icon = asset('images/services/' . $services->icon);
        });
        static::updating(function ($services) {
            if($services->icon){
                $services->icon = basename($services->icon);
            }
        });
    }
}
