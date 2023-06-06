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

    public function all()
    {
        return $this->vendor->with(['category','subCategories','package','features', 'banners'])->get();
    }

    public function find($request)
    {
        // $this->vendor->incrementVisits();
        return $this->vendor->with(['category','subCategories', 'banners'])->findOrFail($request->id);
    }

    public function create($request)
    {
        $subCategories = $request->subcategories ?? [];
        if($request->has('image'))
            FileHelper::addFile($request->image);
        $vendor = $this->vendor->create($request->all());
        $vendor->subcategories()->attach($subCategories);
        $this->addImage($vendor,$request->file('image'));
        return $vendor;

    }

    public function update($request)
    {

        $subCategories = $request->subcategories ?? [];
        if($request->has('image'))
            FileHelper::addFile($request->image);
        $vendor = $this->vendor->findOrFail($request->id);

        $vendor->subcategories()->detach();
        $vendor->subcategories()->attach($subCategories);
        $vendor->update($request->all());
        $this->addImage($vendor,$request->file('image'));
        return $vendor;
    }

    public function delete($request)
    {
        $this->vendor->findOrFail($request->id)->delete();
    }
    public function changeStatus($request)
    {
        $this->vendor->findOrFail($request->id)->update([
            'is_active'=>$request->is_active
        ]);
    }
    public function addImage($vendor , $image)
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
