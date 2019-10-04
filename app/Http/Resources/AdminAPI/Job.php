<?php

namespace App\Http\Resources\AdminAPI;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\Http\Resources\AdminAPI\User as UserResource;
use App\Http\Resources\AdminAPI\JobMeta as JobMetaResource;

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
            'created_at' => $this->created_at,
            'driver' => UserResource::make(User::find($this->user_id)),
            'customer' => UserResource::make(User::find($this->customer_id)),
            'status' => $this->status,
            'job_metas' => JobMetaResource::collection($this->meta)
        ];
    }
}
