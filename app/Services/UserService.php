<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vendor;
use App\Traits\distanceItineraryTrait;
use Illuminate\Support\Facades\Auth;

class UserService
{
    use distanceItineraryTrait;

    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function all($request)
    {
        return $this->user->all();
    }

    public function find($request)
    {
        return $this->user->findOrFail($request->id);
    }

    public function create($request)
    {
        return $this->user->create($request->all());
    }

    public function update($request)
    {
        return tap($this->user->findOrFail($request->id)->update($request->all()));
    }

    public function delete($request)
    {
        $this->user->findOrFail($request->id)->delete();
    }

    public function addVendorToFavorite($request)
    {
        $user = $this->user->findOrFail(Auth::id());
        $user->favoriteVendors()->attach($request->vendor_id);
        return $user;
    }
    public function removeVendorToFavorite($request)
    {
        $user = $this->user->findOrFail(Auth::id());
        $user->favoriteVendors()->detach($request->vendor_id);
        return $user;
    }
    public function getFavoriteVendors($request)
    {
        $user = $this->user->findOrFail(Auth::id());
        $favoriteVendors = $user->favoriteVendors;
        return $favoriteVendors;
    }
    public function getNearbyVendors($request)
    {
        $user = $this->user->findOrFail(Auth::id());
        $vendors = Vendor::where('is_active', 1)->get();
        $nearby = collect();
        foreach ($vendors as $vendor) {
            $dist = $this->distance($request->latitude, $request->longitude, $vendor->latitude, $vendor->longitude);

            if ($dist <= 5) {
                $vendor->user_distance = $dist;
                $nearby->push($vendor);
            }
        }
        $nearby = $nearby->sortBy('user_distance')->values();

        return $nearby;
    }

    public function changeEnableNotification($request)
    {
        $user = $this->user->findOrFail(Auth::id());
        $user->enable_notification = $request->enable_notification;
        $user->save();
        return $user;
    }
}
