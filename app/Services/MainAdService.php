<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\MainAd;

class MainAdService
{
    protected $mainAd;

    public function __construct()
    {
        $this->mainAd = new MainAd();
    }

    public function all($request)
    {
        return $this->mainAd->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")->active()->get();
    }

    public function find($request)
    {
        return $this->mainAd->findOrFail($request->id);
    }

    public function create($request)
    {
        $mainAd = $this->mainAd->create($request->all());

        if ($request->has('image')) {
            $mainAd->image = FileHelper::addFile(request()->file('image'), 'images/mainAds');
        }
        $mainAd->save();

        return $mainAd;
    }

    public function update($request)
    {
        $mainAd = $this->mainAd->findOrFail($request->id);
        $mainAd->update($request->all());

        if ($request->has('image')) {
            $image = $mainAd->image;
            $mainAd->image = FileHelper::addFile(request()->file('image'), 'images/mainAds');
            FileHelper::deleteFile($image,'images/mainAds');

        }
        $mainAd->save();

        return $mainAd;
    }

    public function delete($request)
    {
        $mainAd =  $this->mainAd->findOrFail($request->id);
        FileHelper::deleteFile($mainAd->image,'images/mainAds');
        $mainAd->delete();
    }

    public function updateStatus($request)
    {
        $mainAd = $this->mainAd->findOrFail($request->id);
        $mainAd->is_active = $request->is_active;
        $mainAd->save();
        return $mainAd;
    }

    public function clickIncrement($request)
    {
        $mainAd = $this->mainAd->findOrFail($request->id);
        $mainAd->increment('click_counts');
    }
}
