<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Ad;

class AdService
{
    protected $ad;

    public function __construct()
    {
        $this->ad = new Ad();
    }

    public function all($request)
    {
        return $this->ad->with('category')->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")->active()->get();

    }

    public function find($request)
    {
        return $this->ad->with('category')->findOrFail($request->id);
    }

    public function create($request)
    {
        $ad = $this->ad->create($request->all());

        if ($request->has('image')) {
            $ad->image = FileHelper::addFile(request()->file('image'), 'images/categoryAds');
        }
        $ad->save();

        return $ad;
    }

    public function update($request)
    {
        $ad = $this->ad->findOrFail($request->id);
        $ad->update($request->all());
        if ($request->has('image')) {
            $image = $ad->image;
            $ad->image = FileHelper::addFile(request()->file('image'), 'images/categoryAds');
            FileHelper::deleteFile($image,'images/categoryAds');
        }
        return $ad;
    }

    public function delete($request)
    {
        $ad =  $this->ad->findOrFail($request->id);
        FileHelper::deleteFile($ad->image,'images/categoryAds');
        $ad->delete();
    }

    public function updateStatus($request)
    {
        $ad = $this->ad->findOrFail($request->id);
        $ad->is_active = $request->is_active;
        $ad->save();
        return $ad;
    }

    public function clickincrement($request)
    {
        $ad = $this->ad->findOrFail($request->id);
        $ad->increment('click_counts');
    }
}
