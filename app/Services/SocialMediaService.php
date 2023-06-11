<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\SocialMedia;

class SocialMediaService
{
    protected $socialMedia;

    public function __construct()
    {
        $this->socialMedia = new SocialMedia();
    }

    public function all($request)
    {
        return $this->socialMedia->all();
    }

    public function find($request)
    {
        return $this->socialMedia->findOrFail($request->id);
    }

    public function create($request)
    {
        $socialMedia = $this->socialMedia->create($request->all());

        if ($request->has('image')) {
            $socialMedia->image = FileHelper::addFile(request()->file('image'), 'images/socialMedia');
        }
        $socialMedia->save();

        return $socialMedia;
    }

    public function update($request)
    {
        $socialMedia = $this->socialMedia->findOrFail($request->id);
        $socialMedia->update($request->all());

        if ($request->has('image')) {
            $socialMedia->image = FileHelper::addFile(request()->file('image'), 'images/socialMedia');
        }
        $socialMedia->save();

        return $socialMedia;
    }

    public function delete($request)
    {
        $this->socialMedia->findOrFail($request->id)->delete();
    }
}
