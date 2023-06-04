<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Category;

class CategoryService
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function all()
    {
        return $this->category->with('subCategories')->orderBy('featured','desc')->get();
    }

    public function find($request)
    {
        return $this->category->with('subCategories')->findOrFail($request->id);
    }

    public function create($request)
    {

        if ($request->has('image'))
            FileHelper::addFile($request->image);
        if ($request->has('thumbnail'))
            FileHelper::addFile($request->thumbnail);
        $category = $this->category->create($request->all());
        $this->addImage($category,$request->file('image') , $request->file('thumbnail'));
        return $category;
    }

    public function update($request)
    {
        if ($request->has('image'))
            FileHelper::addFile($request->image);
        if ($request->has('thumbnail'))
            FileHelper::addFile($request->thumbnail);
        $category = $this->category->findOrFail($request->id);
        $category->update($request->all());
        $this->addImage($category,$request->file('image') , $request->file('thumbnail'));
        return $category;
    }

    public function delete($request)
    {
        $category = $this->category->findOrFail($request->id);
        $category->subCategories()->delete();
        $category->vendors()->delete();
        $category->delete();
    }
    public function changeStatus($request)
    {
        $category = $this->category->findOrFail($request->id);
        $category->update(
            [
                'is_active' => $request->is_active
            ]
        );
        return $category;
    }
    public function addImage($category , $image , $thumbnail)
    {
        $category->image = $image->getClientOriginalName();
        $category->thumbnail = $thumbnail->getClientOriginalName();
        $category->save();
    }
    public function changeFeatured($request)
    {
        
        return $this->category->findOrFail($request->id)->update([

            'featured'=>$request->featured,
        ]);
    }
}
