<?php

namespace App\Http\Controllers\Api;

use App\Models\MainAd;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;

use App\Traits\ResponseTrait;
use App\Services\MainAdService;
use App\Http\Requests\MainAdRequest;

class MainAdController extends Controller
{
    use ResponseTrait;
    protected $mainAdServices;
    public function __construct()
    {
        $this->mainAdServices = new MainAdService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MainAdRequest $request)
    {
        $data = $this->mainAdServices->all($request);
        return $this->success($data, 'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MainAdRequest $request)
    {
        $data = $this->mainAdServices->create($request);
        return $this->success($data, 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MainAd  $mainAd
     * @return \Illuminate\Http\Response
     */
    public function show(MainAdRequest $request)
    {
        //
        $data = $this->mainAdServices->find($request);
        return $this->success($data, 'success');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MainAd  $mainAd
     * @return \Illuminate\Http\Response
     */
    public function update(MainAdRequest $request)
    {
        //
        $data = $this->mainAdServices->update($request);
        return $this->success($data, 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MainAd  $mainAd
     * @return \Illuminate\Http\Response
     */
    public function destroy(MainAdRequest $request)
    {
        $this->mainAdServices->delete($request);
        return $this->success([], 'success');
    }

    public function updateStatus(MainAdRequest $request)
    {
        $this->mainAdServices->updateStatus($request);
        return $this->success([], 'success');
    }

    public function clickIncrement(MainAdRequest $request)
    {
        $this->mainAdServices->clickIncrement($request);
        return $this->success([], 'success');
    }
}
