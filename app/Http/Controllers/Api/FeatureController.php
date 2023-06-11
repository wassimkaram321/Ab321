<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest;
use App\Services\FeatureService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    //
    use ResponseTrait;
    protected $featureServices;

    public function __construct()
    {
        $this->featureServices = new FeatureService();
    }
    public function index(FeatureRequest $featureRequest)
    {
        $data = $this->featureServices->all($featureRequest);
        return $this->success($data, 'success');
    }
    public function show(FeatureRequest $featureRequest)
    {
        $data = $this->featureServices->find($featureRequest);
        return $this->success($data, 'success');
    }
    public function store(FeatureRequest $featureRequest)
    {
        $data = $this->featureServices->create($featureRequest);
        return $this->success($data, 'success');
    }
    public function update(FeatureRequest $featureRequest)
    {
        $this->featureServices->update($featureRequest);
        return $this->success([], 'success');
    }
    public function destroy(FeatureRequest $featureRequest)
    {
        $this->featureServices->delete($featureRequest);
        return $this->success([], 'success');
    }
}
