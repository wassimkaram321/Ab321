<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'description_ar',
        'image',
        'distance',
        'open',
        'close',
        'phone',
        'email',
        'address',
        'address2',
        'latitude',
        'longitude',
        'is_active',
        'is_open',
        'start_date',
        'expire_date',
        'avg_rating',
        'category_id',
    ];

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }
    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class);
    }
    public function features()
    {
        return $this->hasMany(Feature::class);
    }
    public function package()
    {
        return $this->hasOne(Package::class);
    }
    public function story()
    {
        return $this->hasOne(Story::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->start_date = date('Y-m-d', strtotime($model->start_date));
            $model->expire_date = date('Y-m-d', strtotime($model->expire_date));
        });
        static::updating(function ($model) {
            $model->start_date = date('Y-m-d', strtotime($model->start_date));
            $model->expire_date = date('Y-m-d', strtotime($model->expire_date));
        });
        static::deleting(function ($vendor) {
            $vendor->subcategories()->detach();
        });
    }
}
