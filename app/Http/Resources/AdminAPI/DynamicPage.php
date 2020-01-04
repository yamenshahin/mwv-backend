<?php

namespace App\Http\Resources\AdminAPI;

use Illuminate\Http\Resources\Json\JsonResource;
use App\DynamicPageMeta;

class DynamicPage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dynamic_page_metas = DynamicPageMeta::select('*')
        ->where('dynamic_page_id', '=', $this->id)
        ->get();

        $metas = [];
        foreach($dynamic_page_metas as $meta) {
            $metas[$meta->key] = $meta->value;
        }

        return [
            'id' =>  $this->id,
            'category' => $this->page,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'meta' =>  $metas ,
        ];
    }
}
