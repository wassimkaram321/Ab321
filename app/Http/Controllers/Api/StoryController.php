<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryRequest;
use App\Services\StoryService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    //
    use ResponseTrait;
    protected $storyServices;
    public function __construct()
    {
        $this->storyServices = new StoryService();
    }
    public function index(StoryRequest $storyRequest)
    {
        $data = $this->storyServices->all($storyRequest);
        return $this->success($data, 'success');
    }
    public function all(StoryRequest $storyRequest)
    {
        $data = $this->storyServices->getAll($storyRequest);
        return $this->success($data, 'success');
    }
    public function show(StoryRequest $storyRequest)
    {
        $data = $this->storyServices->find($storyRequest);
        return $this->success($data, 'success');
    }
    public function store(StoryRequest $storyRequest)
    {
        $data = $this->storyServices->create($storyRequest);
        return $this->success($data, 'success');
    }
    public function update(StoryRequest $storyRequest)
    {
        $this->storyServices->update($storyRequest);
        return $this->success([], 'success');
    }
    public function destroy(StoryRequest $storyRequest)
    {
        $this->storyServices->delete($storyRequest);
        return $this->success([], 'success');
    }
    public function seenStories(StoryRequest $storyRequest)
    {
        $this->storyServices->seenStories($storyRequest);
        return $this->success([], 'success');
    }
    public function updateViews(StoryRequest $storyRequest)
    {
        $this->storyServices->updateViews($storyRequest);
        return $this->success([], 'success');
    }
}
