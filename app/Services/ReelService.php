<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Reel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReelService
{
    protected $reel;

    public function __construct()
    {
        $this->reel = new Reel();
    }

    public function all($request)
    {
        $reels = $this->reel->with('vendor:id,name,name_ar,image')->get();

        $user = User::where('id', Auth::guard('api')->id())->first();
        if (isset($user)) {
            $reelIds = $user->reels->pluck('id')->toArray();
            foreach ($reels as $reel) {
                $reel['seen'] = in_array($reel->id, $reelIds) ? 1 : 0;
                $reel['video'] = asset('images/reels/' . $reel->video);
            }
        }


        return $reels->sortBy('seen')->values();
    }


    public function find($request)
    {
        return $this->reel->app($request->id)->findOrFail($request->id);
    }

    public function create($request)
    {
        $reel = $this->reel->create($request->all());
        if ($request->has('video')) {
            $reel->update([
                'video' => FileHelper::addFile(request()->file('video'), 'images/reels'),
            ]);
        }
        return $reel;
    }

    public function update($request)
    {
        $reel = $this->reel->findOrFail($request->id);
        $reel->update($request->all());
        if ($request->has('video')) {
            $video = $reel->video;
            $reel->update([
                'video' => FileHelper::addFile(request()->file('video'), 'images/reels'),
            ]);
            FileHelper::deleteFile($video, 'images/reels');
        }
        return $reel;
    }

    public function delete($request)
    {

        $reel = $this->reel->findOrFail($request->id);
        FileHelper::deleteFile($reel->video, 'images/reels');
        $reel->delete();
    }
    public function seenReels($request)
    {
        $ids = $request->ids;
        $user = User::where('id', Auth::guard('api')->id())->first();
        if (isset($user)) {
            foreach ($ids as $id) {
                $user->reels()->syncWithoutDetaching($id);
            }
        }
    }
}
