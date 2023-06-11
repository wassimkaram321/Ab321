<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageRequest;
use App\Services\PackageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    //
    use ResponseTrait;
    protected $packageServices;
    public function __construct()
    {
        $this->packageServices = new PackageService();
    }
    public function index(PackageRequest $packageRequest)
    {
        $data = $this->packageServices->all($packageRequest);
        return $this->success($data, 'success');
    }
    public function show(PackageRequest $packageRequest)
    {
        $data = $this->packageServices->find($packageRequest);
        return $this->success($data, 'success');
    }
    public function store(PackageRequest $packageRequest)
    {
        $data = $this->packageServices->create($packageRequest);
        return $this->success($data, 'success');
    }
    public function update(PackageRequest $packageRequest)
    {
        $this->packageServices->update($packageRequest);
        return $this->success([], 'success');
    }
    public function destroy(PackageRequest $packageRequest)
    {
        $this->packageServices->delete($packageRequest);
        return $this->success([], 'success');
    }
    public function addVendorPackage(PackageRequest $packageRequest)
    {
        $data = $this->packageServices->addVendorPackage($packageRequest);
        return $this->success($data, 'success');
    }
    public function addVendorFeatures(PackageRequest $packageRequest)
    {
        $data = $this->packageServices->addVendorFeatures($packageRequest);
        return $this->success($data, 'success');
    }
}
