<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'name_ar',
        'description',
        'description_ar',
        'is_active',
        'price',
        'start_date',
        'end_date',
    ];

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->start_date = date('Y-m-d', strtotime($model->start_date));
            $model->end_date = date('Y-m-d', strtotime($model->end_date));
        });
        static::updating(function ($model) {
            $model->start_date = date('Y-m-d', strtotime($model->start_date));
            $model->end_date = date('Y-m-d', strtotime($model->end_date));
        });
        static::deleting(function ($package) {
            $package->features()->delete();
        });
    }
}
