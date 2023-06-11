<?php

namespace App\Services;

use App\Models\Story;
use App\Models\User;
use App\Models\Vendor;

class StoryService
{
    protected $story;

    public function __construct()
    {
        $this->story = new Story();
    }

    public function all($request)
    {
        $vendor = Vendor::findOrFail($request->vendor_id);
        return $vendor->stories()->with('storyDetails')->get();
    }
    public function getAll($request)
    {
       return $this->story->with('vendor')->get();
    }

    public function find($request)
    {
        return $this->story->with('storyDetails')->findOrFail($request->id);
    }

    public function create($request)
    {
        $story = $this->story->wherevendor_id($request->vendor_id)->first();

        if($story == null)
        {
            $story = $this->story->create([
                'vendor_id'=>$request->vendor_id
            ]);
        }
        $request->merge(['story_id'=>$story->id]);
        (new StoryDetailsService())->create($request);
        return $story->with('storyDetails');
    }

    public function update($request)
    {
        $story = $this->story->wherevendor_id($request->vendor_id)->first();
        $story->update([
            'views'=>$request->views,
        ]);
        $request->merge(['story_id'=>$story->id]);
        (new StoryDetailsService())->update($request);
        return $story->with('storyDetails');
    }

    public function delete($request)
    {
        $this->story->findOrFail($request->id)->delete();
    }
    public function seenStories($request)
    {
        $ids = $request->ids;
        $userId = auth()->user()->id;
        $user = User::findOrFail($userId);
        foreach($ids as $id){
            $user->stories()->syncWithoutDetaching($id);
        }
    }
}
