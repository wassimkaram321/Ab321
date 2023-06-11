<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Category;
use App\Models\Day;
use App\Models\Vendor;
use Carbon\Carbon;

class VendorService
{
    protected $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function all()
    {
        return $this->vendor
            ->with(['days', 'category', 'subCategories', 'socialMedia', 'package', 'features', 'banners'])
            ->withCount('favoriteUsers')->app();
    }

    public function find($request)
    {
        // $this->vendor->incrementVisits();

        return $this->vendor->with(['days', 'category', 'subCategories', 'socialMedia', 'banners'])->withCount('favoriteUsers')->findOrFail($request->id);
    }

    public function create($request)
    {
        $subCategories = $request->subcategories ?? [];
        if ($request->has('image'))
            FileHelper::addFile($request->image);
        $vendor = $this->vendor->create($request->all());
        $vendor->subcategories()->attach($subCategories);
        $this->addImage($vendor, $request->file('image'));
        if (isset($request->days)) {
            foreach ($request->days as $day) {
                $vendor->days()->attach([$day['day_id'] => ['open_at' => $day['open_at'], 'close_at' => $day['close_at']]]);
            }
        }
        if (isset($request->social_media)) {
            foreach ($request->social_media as $social_media) {
                $vendor->socialMedia()->attach([$social_media['id'] => ['link' => $social_media['link']]]);
            }
        }
        return $vendor;
    }

    public function update($request)
    {

        $subCategories = $request->subcategories ?? [];
        if ($request->has('image'))
            FileHelper::addFile($request->image);
        $vendor = $this->vendor->findOrFail($request->id);

        $vendor->subcategories()->detach();
        $vendor->subcategories()->attach($subCategories);
        $vendor->update($request->all());
        $this->addImage($vendor, $request->file('image'));
        if (isset($request->days)) {
            foreach ($request->days as $day) {
                if ($vendor->days()->where('days.id', $day['day_id'])->exists()) {
                    $vendor->days()->updateExistingPivot($day['day_id'], ['open_at' => $day['open_at'], 'close_at' => $day['close_at']]);
                } else {
                    $vendor->days()->attach([$day['day_id'] => ['open_at' => $day['open_at'], 'close_at' => $day['close_at']]]);
                }
            }
            // Remove days that are not included in the days array
            $existingDays = $vendor->days()->pluck('days.id')->toArray();
            $daysToRemove = array_diff($existingDays, array_column($request->days, 'day_id'));

            if (!empty($daysToRemove)) {
                $vendor->days()->detach($daysToRemove);
            }
        }

        if (isset($request->social_media)) {
            foreach ($request->social_media as $social_media) {
                if ($vendor->socialMedia()->where('social_media.id', $social_media['id'])->exists()) {
                    $vendor->socialMedia()->updateExistingPivot($social_media['id'], ['link' => $social_media['link']]);
                } else {
                    $vendor->socialMedia()->attach([$social_media['id'] => ['link' => $social_media['link']]]);
                }
            }
            // Remove midea that are not included in the days array
            $existingMedia = $vendor->socialMedia()->pluck('social_media.id')->toArray();
            $MediaToRemove = array_diff($existingMedia, array_column($request->social_media, 'id'));

            if (!empty($MediaToRemove)) {
                $vendor->socialMedia()->detach($MediaToRemove);
            }
        }
        return $vendor;
    }

    public function delete($request)
    {
        $this->vendor->findOrFail($request->id)->delete();
    }
    public function changeStatus($request)
    {
        $this->vendor->findOrFail($request->id)->update([
            'is_active' => $request->is_active
        ]);
    }
    public function addImage($vendor, $image)
    {
        $vendor->image = $image->getClientOriginalName();
        $vendor->save();
    }
    public function getCategoryVendors($request)
    {
        $category = Category::findOrFail($request->category_id);
        return $category->vendors;
    }
}
