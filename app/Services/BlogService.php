<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Blog;

class BlogService
{
    protected $blog;

    public function __construct()
    {
        $this->blog = new Blog();
    }

    public function all($request)
    {
        return $this->blog->all();
    }

    public function find($request)
    {
        return $this->blog->findOrFail($request->id);
    }

    public function create($request)
    {
        $blog = $this->blog->create($request->all());
        if ($request->has('image')) {
            $blog->image = FileHelper::addFile(request()->file('image'), 'images/blogs');
            $blog->save();
        }
        return $blog;
    }

    public function update($request)
    {
        $blog = $this->blog->findOrFail($request->id);
        $blog->update($request->all());
        if ($request->has('image')) {
            $image = $blog->image;
            $blog->image = FileHelper::addFile(request()->file('image'), 'images/blogs');
            FileHelper::deleteFile($image,'images/blogs');
        }
        return $blog;
    }

    public function delete($request)
    {
        $this->blog->findOrFail($request->id)->delete();
    }
}
