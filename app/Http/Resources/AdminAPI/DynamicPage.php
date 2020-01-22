<?php

namespace App\Http\Resources\AdminAPI;

use Illuminate\Http\Resources\Json\JsonResource;
use App\DynamicPageMeta;
Use App\DynamicPageFile;

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

        $dynamicPageFile = DynamicPageFile::select('*')
        ->where([
            ['page_id', '=', $this->id],
            ['key', '=', 'mainSliderBackground'],
        ])
        ->first();

        $metas = [];
        foreach($dynamic_page_metas as $meta) {
            $metas[$meta->key] = $meta->value;
        }

        return [
            'id' =>  $this->id,
            'slug' => $this->slug,
            'parentSlug' => $this->parent_slug,
            'file' => null,
            'url' => $dynamicPageFile['url'],
            'meta' =>  $metas ,
        ];
    }
}
