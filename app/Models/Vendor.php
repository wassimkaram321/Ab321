<?php

namespace App\Models;

use Digikraaft\ReviewRating\Traits\HasReviewRating;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory, HasReviewRating;
    public $timestamps = true;

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
        'custom_date',
        'website',
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
    public function reels()
    {
        return $this->hasMany(Reel::class);
    }

    // many to many
    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorite_vendors', 'vendor_id' ,'user_id');
    }



    protected static function booted()
    {
        static::creating(function ($model) {
            $model->start_date = date('Y-m-d', strtotime($model->start_date));
            $model->expire_date = date('Y-m-d', strtotime($model->expire_date));
            $model->custom_date = date('Y-m-d', strtotime($model->custom_date));
        });
        static::updating(function ($model) {
            $model->start_date = date('Y-m-d', strtotime($model->start_date));
            $model->custom_date = date('Y-m-d', strtotime($model->custom_date));
        });
        static::deleting(function ($vendor) {
            $vendor->subcategories()->detach();
            $vendor->features()->detach();
            $vendor->banners()->delete();
            $vendor->reels()->delete();
        });

    }
    public function incrementVisits()
    {
        $this->increment('visits');
    }
    public function scopeApp($query)
    {
        if(request()->is_active == 1)
            return $query->where('is_active', 1);
        else
            return $query;

    }
}
