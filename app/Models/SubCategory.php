<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'name_ar',
        'image',
        'thumbnail',
        'category_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class);
    }

    protected static function booted()
    {
        static::deleting(function ($subcategory) {
            $subcategory->vendors()->detach();
        });
        static::retrieved(function ($subcategory) {
            if(isset($subcategory->image))
                $subcategory->image = asset('images/subcategories/' . $subcategory->image);
            if(isset($subcategory->thumbnail))
            $subcategory->thumbnail = asset('images/subcategories/' . $subcategory->thumbnail);
        });
        static::updating(function ($subcategory) {
            if($subcategory->image){
                $subcategory->image = basename($subcategory->image);
            }
            if($subcategory->thumbnail){
                $subcategory->thumbnail = basename($subcategory->thumbnail);
            }
        });
    }
}
