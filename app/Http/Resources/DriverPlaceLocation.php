<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\User;

class DriverPlaceLocation extends JsonResource
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
            'placeId' => $this->id,
            'user' => UserResource::make(User::find($this->user_id)),
            'address' => $this->address,
            'city' => $this->city,
            'postcode' => $this->postcode,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'distance' => $this->distance,
        ];
    }
}
