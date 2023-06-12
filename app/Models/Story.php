<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Story extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'views',
        'vendor_id',
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function storyDetails()
    {
        return $this->hasMany(StoryDetail::class ,'story_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'story_user');
    }
    protected static function booted()
    {
        static::deleting(function ($story) {
            $story->storyDetails()->delete();
            DB::table('story_user')->where('story_id',$story->id)->delete();
            // Storage::remove('images/'.$story->image);
            // Storage::remove('images/'.$story->video);

        });
    }
}
