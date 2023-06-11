<?php

namespace App\Http\Controllers\Api;

use App\Models\SocialMedia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;
use App\Traits\ResponseTrait;
use App\Services\SocialMediaService;
use App\Http\Requests\SocialMediaRequest;

class SocialMediaController extends Controller
{
    use ResponseTrait;
    protected $socialMediaServices;
    public function __construct()
    {
        $this->socialMediaServices = new SocialMediaService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SocialMediaRequest $request)
    {
        $data = $this->socialMediaServices->all($request);
        return $this->success($data,'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SocialMediaRequest $request)
    {
        $data = $this->socialMediaServices->create($request);
        return $this->success($data,'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function show(SocialMediaRequest $request)
    {
        $data = $this->socialMediaServices->find($request);
        return $this->success($data,'success');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function update(SocialMediaRequest $request)
    {
        $data = $this->socialMediaServices->update($request);
        return $this->success($data,'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SocialMedia  $socialMedia
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialMediaRequest $request)
    {
        $this->socialMediaServices->delete($request);
        return $this->success([],'success');

    }
}
