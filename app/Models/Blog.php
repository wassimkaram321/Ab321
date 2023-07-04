<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['title','title_ar','content','content_ar','image'];
    protected static function booted()
    {
        static::retrieved(function ($blog) {
            if (isset($blog->image))
                $blog->image = asset('images/blogs/' . $blog->image);
        });
    }
}
