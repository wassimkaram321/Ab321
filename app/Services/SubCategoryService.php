<?php

namespace App\Services;

use App\Models\SubCategory;
use App\Helpers\FileHelper;
class SubCategoryService
{
    protected $subCategory;

    public function __construct(SubCategory $subCategory)
    {
        $this->subCategory = $subCategory;
    }

    public function all()
    {
        return $this->subCategory->with('category')->get();
    }

    public function find($request)
    {
        return $this->subCategory->with('category')->findOrFail($request->id);
    }

    public function create($request)
    {
       
        if ($request->has('image'))
            FileHelper::addFile($request->image);
        if ($request->has('thumbnail'))
            FileHelper::addFile($request->thumbnail);
        $subCategory = $this->subCategory->create($request->all());
        $this->addImage($subCategory,$request->file('image') , $request->file('thumbnail'));
        return $subCategory;
    }

    public function update($request)
    {
        if ($request->has('image'))
            FileHelper::addFile($request->image);
        if ($request->has('thumbnail'))
            FileHelper::addFile($request->thumbnail);
        $subCategory = $this->subCategory->findOrFail($request->id);
        $subCategory->update($request->all());
        $this->addImage($subCategory,$request->file('image') , $request->file('thumbnail'));
        return $subCategory;
    }

    public function delete($request)
    {
        $subCategory = $this->subCategory->findOrFail($request->id);
        $subCategory->delete();
    }
    public function addImage($subCategory , $image , $thumbnail)
    {
        $subCategory->image = $image->getClientOriginalName();
        $subCategory->thumbnail = $thumbnail->getClientOriginalName();
        $subCategory->save();
    }
}
