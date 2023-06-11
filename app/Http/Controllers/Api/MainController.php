<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Day;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Services\MainControllerService;

class MainController extends Controller
{
    use ResponseTrait;

    public function days()
    {
        $data = Day::get();
        return $this->success($data, 'Success');
    }
}
