<?php

namespace App\Services;

use App\Models\Vendor;
use App\Traits\ResponseTrait;
use Digikraaft\ReviewRating\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewService
{

    use ResponseTrait;
    public function __construct()
    {
    }

    public function vendorReviews($request)
    {
        if($request->has('id'))
            $vendor_reviews = Vendor::findOrFail($request->id)->reviews()->get();
        else
            $vendor_reviews = Vendor::with('reviews')->get();
        return $vendor_reviews;
    }
    public function makeReview($request)
    {
        $vendor = Vendor::findOrFail($request->id);
        $user = Auth::user();
        if ($vendor->hasReviewed(auth()->user()))
            return $this->error_message('user has reviewed this realestate');
        $vendor->review($request->review, $user, $request->rate);
        return $vendor;
    }

    public function deleteReview($request)
    {
        return Review::findOrFail($request->id)->delete();

    }
    public function statusChange($request)
    {
        return Review::findOrFail($request->id)->update([
            'status' => $request->status,
        ]);

    }
}
