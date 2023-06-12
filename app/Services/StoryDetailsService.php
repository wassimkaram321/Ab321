<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Story;
use App\Models\StoryDetail;
use Carbon\Carbon;

class StoryDetailsService
{
    protected $storyDetails;

    public function __construct()
    {
        $this->storyDetails = new StoryDetail();
    }

    public function all($request)
    {
        return $this->storyDetails->all();
    }

    public function find($request)
    {
        return $this->storyDetails->findOrFail($request->id);
    }

    public function create($request)
    {

        $storyDetail = new StoryDetail();
        $data = $request->except(['image', 'video']);
        $storyDetail->fill($data);
        $storyDetail->save();

        $story = Story::findOrFail($request->story_id);
        $story->storyDetails()->save($storyDetail);
    }

    public function update($request)
    {
        $story = Story::findOrFail($request->story_id);
        $story->storyDetails()->delete();
        $this->create($request);
    }

    public function delete($request)
    {
        $storyDetails = $this->storyDetails->findOrFail($request->id);
        $storyDetails->delete();
    }
}
