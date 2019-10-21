<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\JobMeta as JobMetaResource;

class DriverJobs extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $customer = UserResource::make(User::find($this->customer_id));
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'customer' => $customer,
            'job_metas' => JobMetaResource::collection($this->meta)
        ];
    }
}
