<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Category;
use App\Models\Vendor;

class VendorService
{
    protected $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function all($request = null)
    {


        $query = $this->vendor
            ->with(['category', 'subCategories', 'package', 'features', 'banners'])
            ->withCount('favoriteUsers')
            ->app();

        if ($request->all()) {
            $query->where(function ($query) use ($request) {
                if ($request->has('is_active')) {
                    $query->where('is_active', $request->is_active);
                }

                if ($request->has('is_open')) {
                    $query->where('is_open', $request->is_open);
                }

                if ($request->has('subcategories')) {
                    $subcategories = $request->subcategories;
                    $query->whereHas('subCategories', function ($query) use ($subcategories) {
                        $query->whereIn('sub_categories.id', $subcategories);
                    });
                }


                if ($request->has('features')) {
                    $features = $request->features;
                    $query->whereHas('features', function ($query) use ($features) {
                        $query->whereIn('features.id', $features);
                    });
                }
                // if ($request->has('latitude') && $request->has('longitude')) {
                
                // }
            });
        }

        return $query->get();
    }

    public function find($request)
    {

        return $this->vendor->with(['category', 'subCategories', 'banners'])->withCount('favoriteUsers')->findOrFail($request->id);
    }

    public function create($request)
    {
        $subCategories = $request->subcategories ?? [];
        $vendor = $this->vendor->create($request->all());
        $vendor->subcategories()->attach($subCategories);
        if ($request->has('image')) {
            $file_name = FileHelper::addFile($request->image);
            $vendor->image = $file_name;
            $vendor->save();
        }
        return $vendor;
    }

    public function update($request)
    {

        $subCategories = $request->subcategories ?? [];
        $vendor = $this->vendor->findOrFail($request->id);
        if ($request->has('image')) {
            $file_name = FileHelper::addFile($request->image);
            $vendor->image = $file_name;
            $vendor->save();
        }
        $vendor->subcategories()->detach();
        $vendor->subcategories()->attach($subCategories);
        $vendor->update($request->all());
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
