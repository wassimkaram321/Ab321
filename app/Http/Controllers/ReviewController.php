<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Services\ReviewControllerService;
use App\Services\ReviewService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    use ResponseTrait;
    protected $reviewServices;
    public function __construct()
    {
        $this->reviewServices = new ReviewService();
    }
    public function RealestateReviews(ReviewRequest $request)
    {
        # code...
        $data = $this->reviewServices->vendorReviews($request);
        return $this->success($data, 'success');
    }
    public function makeRealestateReview(ReviewRequest $request)
    {
        # code...
        $this->reviewServices->makeReview($request);
        return $this->success([], 'success');
    }
    public function deleteRealestateReview(ReviewRequest $request)
    {
        # code...
        $this->reviewServices->deleteReview($request);
        return $this->success([], 'success');
    }
    public function statusChange(ReviewRequest $request)
    {
        $this->reviewServices->statusChange($request);
        return $this->success([], 'success');
    }
}
