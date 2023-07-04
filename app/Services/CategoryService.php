<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Category;

class CategoryService
{
    protected $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function all($request)
    {
        return $this->category->app()
            ->with([
                'subCategories' => function ($query) {
                    $query->withCount('vendors');
                },
                'ads' => function ($query) {
                    $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");
                }
            ])
            ->withCount('vendors')
            ->orderBy('featured', 'desc')
            ->get();
    }
    public function allWithOut($request)
    {
        return $this->category->app()
            ->orderBy('featured', 'desc')
            ->withCount('vendors')
            ->get();
    }

    public function find($request)
    {
        return $this->category
            ->with([
                'subCategories',
                'ads' => function ($query) {
                    $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')");
                }
            ])
            ->withCount('vendors')
            ->findOrFail($request->id);
    }

    public function create($request)
    {
        $category = $this->category->create($request->all());
        if ($request->has('image')){
            $file_name = FileHelper::addFile($request->file('image'),'images/categories');
            $category->image = $file_name;
            $category->save();
        }

        if ($request->has('thumbnail')){
            $file_name = FileHelper::addFile($request->file('thumbnail'),'images/categories');
            $category->thumbnail = $file_name;
            $category->save();
        }

        // $this->addImage($category, $request->file('image'), $request->file('thumbnail'));
        return $category;
    }

    public function update($request)
    {
        $category = $this->category->findOrFail($request->id);
        $category->update($request->all());
        if ($request->has('image')){
            $image = $category->image;
            $file_name = FileHelper::addFile($request->file('image'),'images/categories');
            FileHelper::deleteFile($image,'images/categories');
            $category->image = $file_name;
            $category->save();
        }

        if ($request->has('thumbnail')){
            $thumbnail = $category->thumbnail;
            $file_name = FileHelper::addFile($request->file('thumbnail'),'images/categories');
            FileHelper::deleteFile($thumbnail,'images/categories');
            $category->thumbnail = $file_name;
            $category->save();
        }
        return $category;
    }

    public function delete($request)
    {
        $category = $this->category->findOrFail($request->id);
        $category->subCategories()->delete();
        $category->vendors()->delete();
        $category->ads()->delete();
        FileHelper::deleteFile($category->image,'images/categories');
        FileHelper::deleteFile($category->thumbnail,'images/categories');
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
    public function addImage($category, $image, $thumbnail)
    {
        $category->image = $image->getClientOriginalName();
        $category->thumbnail = $thumbnail->getClientOriginalName();
        $category->save();
    }
    public function changeFeatured($request)
    {
        return $this->category->findOrFail($request->id)->update([

            'featured' => $request->featured,
        ]);
    }
}
