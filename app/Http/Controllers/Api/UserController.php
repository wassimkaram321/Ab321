<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;
use App\Traits\ResponseTrait;
use App\Services\UserService;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    use ResponseTrait;
    protected $userServices;
    public function __construct()
    {
        $this->userServices = new UserService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRequest $request)
    {
        //
        $data = $this->userServices->all($request);
        return $this->success($data,'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
        $data = $this->userServices->create($request);
        return $this->success($data,'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(UserRequest $request)
    {
        //
        $data = $this->userServices->find($request);
        return $this->success($data,'success');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        //
        $data = $this->userServices->update($request);
        return $this->success($data,'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRequest $request)
    {
        //
        $this->userServices->delete($request);
        return $this->success([],'success');
    }

    public function addVendorToFavorite(UserRequest $request)
    {
        $data = $this->userServices->addVendorToFavorite($request);
        return $this->success([],'success');
    }

    public function removeVendorToFavorite(UserRequest $request)
    {
        $data = $this->userServices->removeVendorToFavorite($request);
        return $this->success([],'success');
    }

    public function getFavoriteVendors(UserRequest $request)
    {
        $data = $this->userServices->getFavoriteVendors($request);
        return $this->success($data,'success');
    }

    public function getNearbyVendors(UserRequest $request)
    {
        $data = $this->userServices->getNearbyVendors($request);
        return $this->success($data,'success');
    }

    public function getAllUsers(UserRequest $request)
    {
        $data = $this->userServices->getAllUsers($request);


    public function changeEnableNotification(UserRequest $request)
    {
        $data = $this->userServices->changeEnableNotification($request);

        return $this->success($data,'success');
    }
}
