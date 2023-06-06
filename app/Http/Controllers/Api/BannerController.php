<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Services\BannerService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    use ResponseTrait;
    protected $bannerServices;

    public function __construct()
    {
        $this->bannerServices = new BannerService();
    }

    public function index(BannerRequest $bannerRequest)
    {
        $data = $this->bannerServices->all($bannerRequest);
        return $this->success($data, 'success');
    }

    public function show(BannerRequest $bannerRequest)
    {
        $data = $this->bannerServices->find($bannerRequest);
        return $this->success($data, 'success');
    }

    public function store(BannerRequest $bannerRequest)
    {
        $data = $this->bannerServices->create($bannerRequest);
        return $this->success($data, 'success');
    }

    public function update(BannerRequest $bannerRequest)
    {
        $this->bannerServices->update($bannerRequest);
        return $this->success([], 'success');
    }

    public function destroy(BannerRequest $bannerRequest)
    {
        $this->bannerServices->delete($bannerRequest);
        return $this->success([], 'success');
    }

    public function updateStatus(BannerRequest $bannerRequest)
    {
        $this->bannerServices->updateStatus($bannerRequest);
        return $this->success([],'success');
    }
}
