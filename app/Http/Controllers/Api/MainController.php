<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;


    

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Services\MainControllerService;
use App\Models\Day;
use App\Services\MainService;

class MainController extends Controller
{
    //
    use ResponseTrait;
    protected $mainServices;
    public function __construct()
    {
        $this->mainServices = new MainService();
    }
    public function home(Request $request)
    {
        $data = $this->mainServices->home($request);
        return $this->success($data,'success');
    }
    
    public function days()
    {
        $data = Day::get();
        return $this->success($data, 'Success');
    }

}
