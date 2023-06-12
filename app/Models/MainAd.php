<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainAd extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'start_date',
        'end_date',
        'priority',
        'url',
        'click_count',
        'is_active',
        'image',
    ];
    public static function booted()
    {
        static::retrieved(function ($ad) {
            $ad->image = asset('images/mainAds/' . $ad->image);
        });
    }
}
