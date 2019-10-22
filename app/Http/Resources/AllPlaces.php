<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AllPlaces extends JsonResource
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
            'distance' => $this->distance,
            'center' => [
                'lat' => $this->lat,
                'lng' => $this->lng,
            ]
        ];
    }
}
