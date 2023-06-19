<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'name_ar',
        'icon',
        'package_id',
    ];
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'feature_vendor', 'feature_id', 'vendor_id')->withPivot('content');
    }
    public static function booted()
    {
        static::retrieved(function ($feature) {
            if(isset($feature->icon))
                $feature->icon = asset('images/features/' . $feature->icon);
        });
        static::updating(function ($feature) {
            if($feature->icon){
                $feature->icon = basename($feature->icon);
            }
        });
    }
}
