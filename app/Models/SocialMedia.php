<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;

    protected $table = 'social_media';

    protected $fillable = ['name', 'name_ar', 'image'];

    // many to many
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_social_media', 'social_media_id', 'vendor_id');
    }

    protected static function booted()
    {
        static::deleting(function ($socialMedia) {
            $socialMedia->vendors()->detach();
        });
        static::retrieved(function ($socialMedia) {
            if(isset($socialMedia->image))
                $socialMedia->image = asset('images/socialMedia/' . $socialMedia->image);
        });
        static::updating(function ($socialMedia) {
            if($socialMedia->image){
                $socialMedia->image = basename($socialMedia->image);
            }
        });
    }

}
