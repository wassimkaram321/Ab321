<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;;
use App\Traits\ResponseTrait;
use App\Services\BlogService;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    use ResponseTrait;
    protected $blogServices;
    public function __construct()
    {
        $this->blogServices = new BlogService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogRequest $request)
    {
        //
        $data = $this->blogServices->all($request);
        return $this->success($data,'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        //
        $data = $this->blogServices->create($request);
        return $this->success($data,'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(BlogRequest $request)
    {
        //
        $data = $this->blogServices->find($request);
        return $this->success($data,'success');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request)
    {
        //
        $data = $this->blogServices->update($request);
        return $this->success($data,'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogRequest $request)
    {
        //
        $this->blogServices->delete($request);
        return $this->success([],'success');

    }
}
