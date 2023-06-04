<?php

namespace App\Services;

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
        return $this->feature->create($request->all());
    }

    public function update($request)
    {
        return tap($this->feature->findOrFail($request->id)->update($request->all()));
    }

    public function delete($request)
    {
        $this->feature->findOrFail($request->id)->delete();
    }
}
