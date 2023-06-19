<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'description_ar',
        'image',
        'thumbnail',
        'is_active',
        'featured',
        'color',
    ];
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }
    public function scopeApp($query)
    {
        if(request()->has('featured'))
            return $query->where('featured', 1);
        else
            return $query;

    }
    public static function booted()
    {

        static::retrieved(function ($category) {
            if(isset($category->image))
                $category->image = asset('images/categories/'.$category->image);
            if(isset($category->thumbnail))
                $category->thumbnail = asset('images/categories/'.$category->thumbnail);
        });
        static::updating(function ($category) {
            if($category->image){
                $category->image = basename($category->image);
            }
        });
    }

}
