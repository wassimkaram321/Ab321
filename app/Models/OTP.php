<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'otps';
    protected $fillable = [
        'code',
        'phone',
    ];
}
