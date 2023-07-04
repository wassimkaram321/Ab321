<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Services;

class ServicesService
{
    protected $services;

    public function __construct()
    {
        $this->services = new Services();
    }

    public function all($request)
    {
        return $this->services->all();
    }

    public function find($request)
    {
        return $this->services->findOrFail($request->id);
    }

    public function create($request)
    {

        return $this->services->create($request->all());
    }

    public function update($request)
    {
        $services = $this->services->where('title',$request->title)->orWhere('title_ar',$request->title)->first();
        $services->update($request->all());
        if ($request->has('icon')) {
            $icon = $services->icon;
            $services->update([
                'icon' => FileHelper::addFile(request()->file('icon'), 'images/services'),
            ]);
            FileHelper::deleteFile($icon, 'images/services');
        }
        return $services;
    }

    public function delete($request)
    {
        $this->services->findOrFail($request->id)->delete();
    }
}
