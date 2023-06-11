<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Jobs\SaveFile;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ResponseTrait;
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $categoryRequest)
    {
        //
        $categories = $this->categoryService->all($categoryRequest);
        return $this->success($categories,'success');
    }
    public function find(CategoryRequest $categoryRequest)
    {
        //
        $category = $this->categoryService->find($categoryRequest);
        return $this->success($category,'success');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CategoryRequest $categoryRequest)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $categoryRequest)
    {
        //
        $category = $this->categoryService->create($categoryRequest);
        return $this->success($category,'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $categoryRequest)
    {
        //
        $category = $this->categoryService->update($categoryRequest);
        return $this->success($category,'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryRequest $categoryRequest)
    {
        //
        $this->categoryService->delete($categoryRequest);
        return $this->success([],'success');
    }
    public function changeStatus(CategoryRequest $categoryRequest)
    {
        //
        $category = $this->categoryService->changeStatus($categoryRequest);
        return $this->success($category,'success');
    }
    public function changeFeatured(CategoryRequest $categoryRequest)
    {
        //
        if($this->categoryService->all($categoryRequest)->sum('featured') >= 5)
            return $this->error_message('Cannot featured more cateogries');
        $this->categoryService->changeFeatured($categoryRequest);
        return $this->success([],'success');
    }
    public function test()
    {
        return view('admin.category.index');
    }
}
