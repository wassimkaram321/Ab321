<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $table = 'days';

    protected $fillable = ['name', 'name_ar'];

    // many to many
    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_day', 'day_id', 'vendor_id');
    }
}
