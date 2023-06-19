<?php

namespace App\Models;

use Carbon\Carbon;
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
            if(isset($ad->image))
                $ad->image = asset('images/mainAds/' . $ad->image);
        });
        static::updating(function ($ad) {
            if($ad->image){
                $ad->image = basename($ad->image);
            }
        });
    }
    public function scopeActive($query)
    {
        $date = date('Y-m-d');

        if (request()->is_active == 1) {
            return $query->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date);
        } else {
            return $query;
        }
    }
}
