<?php

namespace App\Services;

use App\Helpers\FileHelper;
use App\Models\Feature;

class FeatureService
{
    protected $feature;

    public function __construct()
    {
        $this->feature = new Feature();
    }

    public function all($request)
    {
        return $this->feature->with('package')->get();
    }

    public function find($request)
    {
        return $this->feature->with('package')->findOrFail($request->id);
    }

    public function create($request)
    {
        $feature = $this->feature->create($request->all());
        if($request->has('icon')){
            $icon = FileHelper::addFile($request->file('icon'),'images/features');
            $feature->icon = $icon;
            $feature->save();
        }
    }

    public function update($request)
    {
        return tap($this->feature->findOrFail($request->id)->update($request->all()));
    }

    public function delete($request)
    {
        $feature = $this->feature->findOrFail($request->id);
        FileHelper::deleteFile($feature->icon,'images/features');
        $feature->delete();
    }
}
