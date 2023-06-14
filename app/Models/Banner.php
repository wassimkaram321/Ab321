<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'name',
        'description',
        'vendor_id',
        'start_date',
        'end_date',
        'priority',
        'url',
        'click_count',
        'is_active',
        'image',
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public static function booted()
    {
        static::retrieved(function ($banner) {
            $banner->image = asset('images/banners/' . $banner->image);
        });
        static::updating(function ($banner) {
            if($banner->image){
                $banner->image = basename($banner->image);
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
