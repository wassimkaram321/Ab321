<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'description_ar',
        'image',
        'thumbnail',
        'is_active',
        'featured',
        'color',
    ];
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class);
    }
    public function scopeApp($query)
    {
        if(request()->has('featured'))
            return $query->where('featured', 1);
        else
            return $query;

    }

}
