<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use App\Services\SubCategoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    use ResponseTrait;
    protected $subCategoryServices;
    public function __construct(SubCategoryService $subCategoryServices)
    {
        $this->subCategoryServices = $subCategoryServices;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SubCategoryRequest $subCategoryRequest)
    {
        //
        $data = $this->subCategoryServices->all($subCategoryRequest);
        return $this->success($data, 'success');
    }
    public function find(SubCategoryRequest $subCategoryRequest)
    {
        //
        $data = $this->subCategoryServices->find($subCategoryRequest);
        return $this->success($data, 'success');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(SubCategoryRequest $subCategoryRequest)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest $subCategoryRequest)
    {
        //
        $data = $this->subCategoryServices->create($subCategoryRequest);
        return $this->success($data, 'success');
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
    public function update(SubCategoryRequest $subCategoryRequest)
    {
        //
        $data = $this->subCategoryServices->update($subCategoryRequest);
        return $this->success($data, 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategoryRequest $subCategoryRequest)
    {
        //
        $this->subCategoryServices->delete($subCategoryRequest);
        return $this->success([], 'success');
    }
}
