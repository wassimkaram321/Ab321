<?php

namespace App\Models;

use Carbon\Carbon;
use Digikraaft\ReviewRating\Traits\HasReviewRating;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        return $this->belongsToMany(Feature::class, 'feature_vendor');
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
        return $this->belongsToMany(User::class, 'favorite_vendors', 'vendor_id', 'user_id');
    }

    // many to many
    public function days()
    {
        return $this->belongsToMany(Day::class, 'vendor_day', 'vendor_id', 'day_id')
            ->withPivot(['open_at', 'close_at']);
    }

    // many to many
    public function socialMedia()
    {
        return $this->belongsToMany(SocialMedia::class, 'vendor_social_media', 'vendor_id', 'social_media_id')
            ->withPivot(['link']);
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
            $vendor->days()->detach();
            $vendor->socialMedia()->detach();
            $vendor->features()->detach();
            $vendor->banners()->delete();
            $vendor->reels()->delete();
        });

        static::retrieved(function ($vendor) {
            $vendor->image = asset('images/vendors/' . $vendor->image);
        });
    }
    public function incrementVisits()
    {
        $this->increment('visits');
    }

    public function scopeApp($query)
    {
        if (request()->is_active == 1) {
            $newQuery = $query->where('is_active', 1)->get();
        } else {
            $newQuery = $query->get();
        }

        $currentDay = Carbon::now()->format('l');
        $currentTime = Carbon::now()->format('H:i:s');
        $day = Day::where('name', $currentDay)->first();
        $user = User::where('id', Auth::id())->first();

        $filteredVendors = collect();

        foreach ($newQuery as $vendor) {
            $qDay = $vendor->days()->where('day_id', $day->id)->first();
            $fav  = $user->favoriteVendors()->where('vendor_id', $vendor->id)->first();

            $vendor->open_status = 0;
            $vendor->favorite_status = 0;
            if (isset($qDay)) {
                if ($qDay->pivot->open_at < $currentTime && $qDay->pivot->close_at > $currentTime) {
                    $vendor->open_status = 1;
                }
            }
            if (isset($fav)) {
                $vendor->favorite_status = 1;
            }
            if (request()->is_open == 1) {
                if ($vendor->open_status == 1)
                    $filteredVendors->push($vendor);
            } else
                $filteredVendors->push($vendor);
        }
        return $filteredVendors;
    }
    }
