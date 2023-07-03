<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Services;
use Illuminate\Http\Request;;
use App\Traits\ResponseTrait;
use App\Services\ServicesService;
use App\Http\Requests\ServicesRequest;

class ServicesController extends Controller
{
    use ResponseTrait;
    protected $servicesServices;
    public function __construct()
    {
        $this->servicesServices = new ServicesService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ServicesRequest $request)
    {
        //
        $data = $this->servicesServices->all($request);
        return $this->success($data,'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServicesRequest $request)
    {
        //
        $data = $this->servicesServices->create($request);
        return $this->success($data,'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show(ServicesRequest $request)
    {
        //
        $data = $this->servicesServices->find($request);
        return $this->success($data,'success');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(ServicesRequest $request)
    {
        //
        $data = $this->servicesServices->update($request);
        return $this->success($data,'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicesRequest $request)
    {
        //
        $this->servicesServices->delete($request);
        return $this->success([],'success');

    }
}
