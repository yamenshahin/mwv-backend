<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DynamicPageFile extends JsonResource
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
            'pageId' => $this->page_id,
            'key' => $this->key,
            'url' => $this->url
        ];
    }
}
