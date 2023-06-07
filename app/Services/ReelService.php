<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Reel;

class ReelService
{
    protected $reel;

    public function __construct()
    {
        $this->reel = new Reel();
    }

    public function all($request)
    {
        return $this->reel->get();
    }

    public function find($request)
    {
        return $this->reel->findOrFail($request->id);
    }

    public function create($request)
    {
        $reel = $this->reel->create($request->all());
        if ($request->has('video')) {
            $reel->update([
                'video'=>FileHelper::addFile(request()->file('video'), 'images/reels'),
            ]);
        }
        return $reel;
    }

    public function update($request)
    {
        $reel = $this->reel->findOrFail($request->id);
        $reel->update($request->all());
        if ($request->has('video')) {
            $reel->update([
                'video'=>FileHelper::addFile(request()->file('video'), 'images/reels'),
            ]);
        }
        return $reel;
    }

    public function delete($request)
    {
        $this->reel->findOrFail($request->id)->delete();
    }
}
