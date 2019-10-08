<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\Http\Resources\UserSimple as UserSimpleResource;
use App\Http\Resources\User as UserResource;
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
        if($this->status === 'booked') {
            $driver = UserResource::make(User::find($this->user_id));
        } else {
            $driver = UserSimpleResource::make(User::find($this->user_id));
        }
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'driver' => $driver,
            'status' => $this->status,
            'job_metas' => JobMetaResource::collection($this->meta)
        ];
    }
}
