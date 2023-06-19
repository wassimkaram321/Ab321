<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reel extends Model
{
    use HasFactory;
    protected $fillable = [
        'image', 'video', 'description', 'title', 'views', 'vendor_id'
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'reel_user')->withTimestamps();
    }

    public function scopeApp($query,$reelId)
    {
        return $query;
    }
    public static function booted()
    {
        static::retrieved(function ($reel) {
            if(isset($reel->video))
                $reel->video = asset('images/reels/' . $reel->video);
        });
        static::updating(function ($reel) {
            if($reel->video){
                $reel->video = basename($reel->video);
            }
        });
    }

}
