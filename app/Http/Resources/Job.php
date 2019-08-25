<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\JobMeta as JobMetaResource;

class Job extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->diffForHumans(),
            'user' => $this->user,
            //dd($this->meta),
            'job_metas' => JobMetaResource::collection($this->meta)
        ];
    }
}
