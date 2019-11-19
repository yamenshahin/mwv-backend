<?php

namespace App\Http\Resources\AdminAPI;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackJob extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' =>  $this->id,
            'owner_id' => $this->owner_id,
            'giver_id' => $this->giver_id,
            'stars' => $this->stars,
            'comment' => $this->comment,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'status' => $this->status,
        ];
    }
}
