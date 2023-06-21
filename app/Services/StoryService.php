<?php

namespace App\Services;

use App\Models\Story;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;

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
        return $vendor
        ->with([
            'stories' => function ($query) {
                $query->with('storyDetails');
            }
        ])
        ->get(['name','name_ar'])->first();
    }
    public function getAll($request)
    {
        if($request->has('id')){
            $story = $this->story->findOrFail($request->id);
            return $story->storyDetails;
        }
        return $this->story->with(['storyDetails','vendor:id,name,name_ar'])->withCount('storyDetails')->get();
    }
    public function getAllApi($request)
    {

       return $this->story->get();
    }


    public function find($request)
    {
        return $this->story->with('storyDetails')->findOrFail($request->id);
    }

    public function create($request)
    {

        $vendor = Vendor::findOrFail($request->vendor_id);
        $story = $this->story->wherevendor_id($vendor->id)->first();

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
            DB::table('story_user')->insert([
                'story_id'=>$id,
                'user_id'=>$userId,
            ]);
        }
    }
    public function updateViews($request)
    {
       return $this->story->findOrFail($request->id)->update([
        'views'=>$request->views,
       ]);
    }
}
