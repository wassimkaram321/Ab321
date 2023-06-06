<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Banner;

class BannerService
{
    protected $banner;

    public function __construct()
    {
        $this->banner = new Banner;
    }

    public function all($request)
    {
        return $this->banner->with('vendor')->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")->get();
    }

    public function find($request)
    {
        return $this->banner->with('vendor')->findOrFail($request->id);
    }

    public function create($request)
    {
        $banner = $this->banner->create($request->all());

        if ($request->has('image')) {
            $banner->image = FileHelper::addFile(request()->file('image'), 'images/banners');
        }
        $banner->save();

        return $banner;
    }

    public function update($request)
    {
        $banner = $this->banner->findOrFail($request->id);
        $banner->update($request->all());

        if ($request->has('image')) {
            $banner->image = FileHelper::addFile(request()->file('image'), 'images/banners');
        }
        $banner->save();

        return $banner;
    }

    public function delete($request)
    {
        $this->banner->findOrFail($request->id)->delete();
    }

    public function updateStatus($request)
    {
        $banner = $this->banner->findOrFail($request->id);
        $banner->is_active = $request->is_active;
        $banner->save();
        return $banner;
    }
}
