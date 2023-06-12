<?php

namespace App\Services;

use App\Models\SubCategory;
use App\Helpers\FileHelper;
use App\Models\Category;

class SubCategoryService
{
    protected $subCategory;

    public function __construct(SubCategory $subCategory)
    {
        $this->subCategory = $subCategory;
    }

    public function all($request = null)
    {
        if($request){
            if($request->has('category_id')){
                $category = Category::with(['ads','subCategories'])->findOrFail($request->category_id);
                return ['subcategoris'=>$category->subCategories,'ads'=> $category->ads];
            }
        }

        return $this->subCategory->with('category')->get();
    }

    public function find($request)
    {
        return $this->subCategory->with('category')->findOrFail($request->id);
    }

    public function create($request)
    {
        $subCategory = $this->subCategory->create($request->all());
        if ($request->has('image')){
            $file_name = FileHelper::addFile($request->file('image'),'images/subcategories');
            $subCategory->image = $file_name;
            $subCategory->save();
        }

        if ($request->has('thumbnail')){
            $file_name = FileHelper::addFile($request->file('thumbnail'),'images/subcategories');
            $subCategory->thumbnail = $file_name;
            $subCategory->save();
        }

        // $this->addImage($subCategory,$request->file('image') , $request->file('thumbnail'));
        return $subCategory;
    }

    public function update($request)
    {
        $subCategory = $this->subCategory->findOrFail($request->id);
        $subCategory->update($request->all());
        if ($request->has('image')){
            $image = $subCategory->image;
            $file_name = FileHelper::addFile($request->file('image'),'images/subcategories');
            FileHelper::deleteFile($image,'images/subcategories');
            $subCategory->image = $file_name;
            $subCategory->save();
        }

        if ($request->has('thumbnail')){
            $thumbnail = $subCategory->thumbnail;
            $file_name = FileHelper::addFile($request->file('thumbnail'),'images/subcategories');
            FileHelper::deleteFile($thumbnail,'images/subcategories');
            $subCategory->thumbnail = $file_name;
            $subCategory->save();
        }

        // $this->addImage($subCategory,$request->file('image') , $request->file('thumbnail'));
        return $subCategory;
    }

    public function delete($request)
    {
        $subCategory = $this->subCategory->findOrFail($request->id);
        FileHelper::deleteFile($subCategory->image,'images/subcategories');
        FileHelper::deleteFile($subCategory->thumbnail,'images/subcategories');
        $subCategory->delete();
    }
    public function addImage($subCategory , $image , $thumbnail)
    {
        $subCategory->image = $image->getClientOriginalName();
        $subCategory->thumbnail = $thumbnail->getClientOriginalName();
        $subCategory->save();
    }
}
