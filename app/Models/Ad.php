<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'start_date',
        'end_date',
        'priority',
        'url',
        'click_count',
        'is_active',
        'category_id',
        'image',
    ];

}
