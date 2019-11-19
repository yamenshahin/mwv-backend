<?php

namespace App\Http\Resources\AdminAPI;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminAPI\User as UserResource;
use App\User;
use App\Job;

class FeedbackJobDetailed extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        $customer = UserResource::make(User::find($this->giver_id));

        $job = Job::find($this->owner_id);
        $driver = UserResource::make(User::find($job->user_id));
        
        return [
            'id' =>  $this->id,
            'owner_id' => $this->owner_id,
            'customer' => $customer,
            'driver' => $driver,
            'stars' => $this->stars,
            'comment' => $this->comment,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ];
    }
}
