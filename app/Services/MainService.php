<?php

namespace App\Services;

use App\Http\Resources\Web\StoryResource;
use App\Models\Main;

class MainService
{


    public function __construct()
    {

    }

    public function home($request)
    {
        $stories = (new StoryService)->getAllApi($request);
        $mainAds = (new MainAdService)->all($request);
        $categories = (new CategoryService)->allWithOut($request);
        $data = [
            'stories' => StoryResource::collection($stories),
            'mainAds' => $mainAds,
            'categories' => $categories
        ];
        return $data;
    }

}
