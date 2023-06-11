<?php

namespace App\Services;

use App\Models\About;

class AboutService
{
    protected $about;

    public function __construct()
    {
        $this->about = new About();
    }

    public function all($request)
    {
        return $this->about->all();
    }

    public function find($request)
    {
        return $this->about->first();
    }

    public function create($request)
    {
        return $this->about->create($request->all());
    }

    public function update($request)
    {
        $about = $this->about->first();
        $about->update([
            'content'=>$request->content,
        ]);
        return $about;
    }

    public function delete($request)
    {
        $this->about->findOrFail($request->id)->delete();
    }
}
