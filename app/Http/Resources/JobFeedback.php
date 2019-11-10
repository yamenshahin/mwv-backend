<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserSimple as UserSimpleResource;
use App\User;

class JobFeedback extends JsonResource
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
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'giver' => UserSimpleResource::make(User::find($this->giver_id)),
            'stars' => $this->stars,
            'comment' => $this->comment,
        ];
    }
}
