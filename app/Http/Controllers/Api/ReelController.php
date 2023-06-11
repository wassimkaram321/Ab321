<?php

namespace App\Http\Controllers\Api;

use App\Models\Reel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;;

use App\Traits\ResponseTrait;
use App\Services\ReelService;
use App\Http\Requests\ReelRequest;

class ReelController extends Controller
{
    use ResponseTrait;
    protected $reelServices;
    public function __construct()
    {
        $this->reelServices = new ReelService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReelRequest $request)
    {
        //
        $data = $this->reelServices->all($request);
        return $this->success($data, 'success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReelRequest $request)
    {
        //
        $data = $this->reelServices->create($request);
        return $this->success($data, 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reel  $reel
     * @return \Illuminate\Http\Response
     */
    public function show(ReelRequest $request)
    {
        //
        $data = $this->reelServices->find($request);
        return $this->success($data, 'success');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reel  $reel
     * @return \Illuminate\Http\Response
     */
    public function update(ReelRequest $request, $id)
    {
        //
        $data = $this->reelServices->update($request);
        return $this->success($data, 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reel  $reel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReelRequest $request)
    {
        //
        $this->reelServices->delete($request);
        return $this->success([], 'success');
    }
    public function seenReels(ReelRequest $request)
    {
        //
        $this->reelServices->seenReels($request);
        return $this->success([], 'success');
    }
}
