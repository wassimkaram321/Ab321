<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'views'=>$this->views,
            'created_at'=>$this->created_at,
            'storyDetails'=>$this->storyDetails,
            'vendor'=>$this->vendor()->get(['id','name','name_ar','image'])
        ];
    }
}
