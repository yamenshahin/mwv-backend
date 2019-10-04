<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobMeta extends JsonResource
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
        
        $keys = ['collection', 'delivery', 'waypoints'];
        if (in_array($this->key, $keys)) {
            $valueFormated = json_decode($this->value);
        } else {
            $valueFormated = $this->value;
        }
        
        return [
            'id' => $this->id,
            'created_at' => $this->created_at->diffForHumans(),
            'key' =>  $this->key,
            'value' =>  $valueFormated
        ];
    }
}
