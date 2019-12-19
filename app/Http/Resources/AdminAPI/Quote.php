<?php

namespace App\Http\Resources\AdminAPI;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminAPI\QuoteMeta as QuoteMetaResource;
use App\QuoteMeta;

class Quote extends JsonResource
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
        
        $customerInfoName = QuoteMeta::select('*')
        ->where([
            ['quote_id', '=', $this->id],
            ['key', '=', 'customerInfoName']
        ])
        ->first();
        $customerInfoEmail = QuoteMeta::select('*')
        ->where([
            ['quote_id', '=', $this->id],
            ['key', '=', 'customerInfoEmail']
        ])
        ->first();
        $customerInfoPhone = QuoteMeta::select('*')
        ->where([
            ['quote_id', '=', $this->id],
            ['key', '=', 'customerInfoPhone']
        ])
        ->first();

        $customer = [
            'name' => $customerInfoName->value,
            'email' => $customerInfoEmail->value,
            'phone' => $customerInfoPhone->value,
        ];

        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'customer' => $customer,
            'quote_metas' => QuoteMetaResource::collection($this->metas),
        ];
    }
}
