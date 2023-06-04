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
}
