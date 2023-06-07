<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    use HasFactory;
    protected $fillable = [
        'image','video','description','title','views','vendor_id'
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
