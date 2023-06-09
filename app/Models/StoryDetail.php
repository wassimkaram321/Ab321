<?php

namespace App\Models;

use App\Helpers\FileHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StoryDetail extends Model
{
    use HasFactory;
    public $timestamps = true;
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
    protected static function booted()
    {
        static::creating(function ($storyDetail) {
            if (request()->hasFile('image')) {
                $imagePath = FileHelper::addFile(request()->file('image'), 'images/stories');
                $storyDetail->image = $imagePath;
            }

            if (request()->hasFile('video')) {
                $videoPath = FileHelper::addFile(request()->file('video'), 'images/stories');
                $storyDetail->video = $videoPath;
            }
        });
        static::updating(function ($storyDetail) {
            if (request()->hasFile('image')) {
                $image = $storyDetail->image;
                $imagePath = FileHelper::addFile(request()->file('image'), 'images/stories');
                FileHelper::deleteFile($image, 'images/stories');
                $storyDetail->image = $imagePath;
            }

            if (request()->hasFile('video')) {
                $video = $storyDetail->video;
                $videoPath = FileHelper::addFile(request()->file('video'), 'images/stories');
                FileHelper::deleteFile($video, 'images/stories');
                $storyDetail->video = $videoPath;
            }
        });
        static::retrieved(function ($storyDetail) {
            if(isset($storyDetail->video))
                $storyDetail->video = asset('images/stories/' . $storyDetail->video);
            if(isset($storyDetail->image))
                $storyDetail->image = asset('images/stories/' . $storyDetail->image);
        });

    }
    
}
