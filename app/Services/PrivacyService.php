<?php

namespace App\Services;

use App\Models\Privacy;

class PrivacyService
{
    protected $privacy;

    public function __construct()
    {
        $this->privacy = new Privacy();
    }

    public function all($request)
    {
        return $this->privacy->all();
    }

    public function find($request)
    {
        return $this->privacy->first();
    }

    public function create($request)
    {
        return $this->privacy->create($request->all());
    }

    public function update($request)
    {
        $privacy = $this->privacy->first();
        $privacy->update([
            'content'=>$request->content,
        ]);
        return $privacy;
    }

    public function delete($request)
    {
        $this->privacy->findOrFail($request->id)->delete();
    }
}
