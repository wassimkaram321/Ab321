<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryDetailsRequest;
use App\Services\StoryDetailsService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class StoryDetailsController extends Controller
{
    //
    use ResponseTrait;
    public $storyDetailsServices;
    public function __construct()
    {
        $this->storyDetailsServices = new StoryDetailsService();
    }
    public function destroy(StoryDetailsRequest $request)
    {
        $this->storyDetailsServices->delete($request);
        return $this->success([],'success');
    }
}
