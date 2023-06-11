<?php

namespace App\Http\Controllers\Api;

use App\Models\Privacy;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;
use App\Traits\ResponseTrait;
use App\Services\PrivacyService;
use App\Http\Requests\PrivacyRequest;

class PrivacyController extends Controller
{
    use ResponseTrait;
    protected $privacyServices;
    public function __construct()
    {
        $this->privacyServices = new PrivacyService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PrivacyRequest $request)
    {
        //
        $data = $this->privacyServices->all($request);
        return $this->success($data,'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrivacyRequest $request)
    {
        //
        $data = $this->privacyServices->create($request);
        return $this->success($data,'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function show(PrivacyRequest $request)
    {
        //
        $data = $this->privacyServices->find($request);
        return $this->success($data,'success');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function update(PrivacyRequest $request)
    {
        //
        $data = $this->privacyServices->update($request);
        return $this->success($data,'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Privacy  $privacy
     * @return \Illuminate\Http\Response
     */
    public function destroy(PrivacyRequest $request)
    {
        //
        $this->privacyServices->delete($request);
        return $this->success([],'success');

    }
}
