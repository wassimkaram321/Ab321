<?php

namespace App\Models;

use Digikraaft\ReviewRating\Traits\HasReviewRating;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory,HasReviewRating;
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
        'package_id',
        'visits',
    ];

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class);
    }
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'feature_vendor')
            ->withPivot('content');
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function stories()
    {
        return $this->hasMany(Story::class);
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
            $vendor->features()->detach();
        });

    }
    public function incrementVisits()
    {
        $this->increment('visits');
    }
}
