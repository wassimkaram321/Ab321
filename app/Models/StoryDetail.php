<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'image',
        'video',
        'description',
        'seen',
        'story_id',
    ];
    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
