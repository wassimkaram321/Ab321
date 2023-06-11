<?php

namespace App\Http\Controllers\Api;

use App\Models\About;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;
use App\Traits\ResponseTrait;
use App\Services\AboutService;
use App\Http\Requests\AboutRequest;

class AboutController extends Controller
{
    use ResponseTrait;
    protected $aboutServices;
    public function __construct()
    {
        $this->aboutServices = new AboutService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AboutRequest $request)
    {
        //
        $data = $this->aboutServices->all($request);
        return $this->success($data,'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AboutRequest $request)
    {
        //
        $data = $this->aboutServices->create($request);
        return $this->success($data,'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function show(AboutRequest $request)
    {
        //
        $data = $this->aboutServices->find($request);
        return $this->success($data,'success');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function update(AboutRequest $request)
    {
        //
        $data = $this->aboutServices->update($request);
        return $this->success($data,'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\About  $about
     * @return \Illuminate\Http\Response
     */
    public function destroy(AboutRequest $request)
    {
        //
        $this->aboutServices->delete($request);
        return $this->success([],'success');

    }
}
