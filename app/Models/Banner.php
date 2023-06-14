<?php

namespace App\Models;

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
}
