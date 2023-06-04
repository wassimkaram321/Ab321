<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
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
}
