<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(Vendor::class);
    }


    // protected static function booted()
    // {
    //     static::creating(function ($category) {
    //         if ($category->image) {
    //             $category->image = $category->image->getClientOriginalName();
    //         }
    //         if ($category->thumbnail) {
    //             $category->thumbnail = $category->thumbnail->getClientOriginalName();
    //         }
    //     });
    //     static::updating(function ($category) {
    //         if ($category->image) {
    //             $category->image = $category->image->getClientOriginalName();
    //         }
    //         if ($category->thumbnail) {
    //             $category->thumbnail = $category->thumbnail->getClientOriginalName();
    //         }
    //     });
    // }
}
