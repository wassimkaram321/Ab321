<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use App\Services\VendorService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    use ResponseTrait;
    protected $vendorServices;
    public function __construct(VendorService $vendorServices)
    {
        $this->vendorServices = $vendorServices;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = $this->vendorServices->all();
        return $this->success($data,'Success');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
        //
        $data = $this->vendorServices->create($request);
        return $this->success($data,'Success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(VendorRequest $request)
    {
        //
        $data = $this->vendorServices->find($request);
        return $this->success($data,'Success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(VendorRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(VendorRequest $request)
    {
        //
        $data = $this->vendorServices->update($request);
        return $this->success($data,'Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(VendorRequest $request)
    {
        //
        $this->vendorServices->delete($request);
        return $this->success([],'Success');
    }
    public function changeStatus(VendorRequest $request)
    {
        //
        $this->vendorServices->changeStatus($request);
        return $this->success([],'Success');
    }
    public function getCategoryVendors(VendorRequest $request)
    {
        //
        $this->vendorServices->getCategoryVendors($request);
        return $this->success([],'Success');
    }
}
