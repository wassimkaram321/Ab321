<?php

namespace App\Services;

use App\Models\Story;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;
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
        $vendors = Vendor::
            with([
                'stories' => function ($query) {
                    $query->with('storyDetails');
                }
            ])
            ->get(['id', 'name', 'name_ar']);
            if (auth()->check()) {
                $user = User::where('id', auth()->user()->id)->first();
            } else {
                $user = User::where('id', Auth::guard('api')->id())->first();
            }
        foreach ($vendors as $vendor) {
            foreach ($vendor->stories as $story) {
                $story->seen = 0;
                if (isset($user)) {
                    $fav = $user->stories()->where('story_id', $story->id)->first();
                    if (isset($fav)) {
                        $story->seen = 1;
                    }
                }
            }
        }
        return $vendors;
    }
    public function getAll($request)
    {
        if ($request->has('id')) {
            $story = $this->story->findOrFail($request->id);
            return $story->storyDetails;
        }
        return $this->story->with(['storyDetails', 'vendor:id,name,name_ar'])->withCount('storyDetails')->get();
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

        if ($story == null) {
            $story = $this->story->create([
                'vendor_id' => $request->vendor_id
            ]);
        }
        $request->merge(['story_id' => $story->id]);
        (new StoryDetailsService())->create($request);
        return $story->with('storyDetails');
    }

    public function update($request)
    {
        $story = $this->story->wherevendor_id($request->vendor_id)->first();
        $story->update([
            'views' => $request->views,
        ]);
        $request->merge(['story_id' => $story->id]);
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
        foreach ($ids as $id) {
            DB::table('story_user')->updateOrInsert([
                'story_id' => $id,
                'user_id' => $userId,
            ]);
        }
    }
    public function updateViews($request)
    {
        return $this->story->findOrFail($request->id)->update([
            'views' => $request->views,
        ]);
    }
}
