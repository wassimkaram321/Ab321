<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Models\User;
use App\Services\NotificationService;
use App\Traits\NotificationTrait;

class NotificationController extends Controller
{
    use ResponseTrait, NotificationTrait;

    protected $notificationServices;
    public function __construct()
    {
        $this->notificationServices = new NotificationService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NotificationRequest $request)
    {
        $data = $this->notificationServices->all($request);
        return $this->success($data,'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        $data = $this->notificationServices->create($request);
        return $this->success($data,'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MainAd  $mainAd
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationRequest $request)
    {
        //
        $data = $this->notificationServices->find($request);
        return $this->success($data,'success');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MainAd  $mainAd
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request)
    {
        //
        $data = $this->notificationServices->update($request);
        return $this->success($data,'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MainAd  $mainAd
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationRequest $request)
    {
        $this->notificationServices->delete($request);
        return $this->success([],'success');
    }

    public function seeAll(NotificationRequest $request)
    {
        $this->notificationServices->seeAll($request);
        return $this->success([],'success');
    }

    public function unseenCount(NotificationRequest $request)
    {
        $data = $this->notificationServices->unseenCount($request);
        return $this->success($data, 'success');
    }

}
