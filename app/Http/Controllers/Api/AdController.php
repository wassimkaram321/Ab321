<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdRequest;
use App\Services\AdService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class AdController extends Controller
{
    use ResponseTrait;
    protected $adServices;

    public function __construct()
    {
        $this->adServices = new AdService();
    }

    public function index(AdRequest $adRequest)
    {
        $data = $this->adServices->all($adRequest);
        return $this->success($data, 'success');
    }

    public function show(AdRequest $adRequest)
    {
        $data = $this->adServices->find($adRequest);
        return $this->success($data, 'success');
    }

    public function store(AdRequest $adRequest)
    {
        $data = $this->adServices->create($adRequest);
        return $this->success($data, 'success');
    }

    public function update(AdRequest $adRequest)
    {
        $this->adServices->update($adRequest);
        return $this->success([], 'success');
    }

    public function destroy(AdRequest $adRequest)
    {
        $this->adServices->delete($adRequest);
        return $this->success([], 'success');
    }

    public function updateStatus(AdRequest $adRequest)
    {
        $this->adServices->updateStatus($adRequest);
        return $this->success([], 'success');
    }

    public function clickIncrement(AdRequest $adRequest)
    {
        $this->adServices->clickIncrement($adRequest);
        return $this->success([], 'success');
    }
}
