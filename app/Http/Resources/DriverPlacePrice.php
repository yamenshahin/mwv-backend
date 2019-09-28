<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\User;

class DriverPlacePrice extends JsonResource
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
            
            
            'priceSmallVanWeekday' => $this->price_small_van_weekday,
            'priceSmallVanWeekday1' => $this->price_small_van_weekday1, 
            'priceSmallVanWeekday2' => $this->price_small_van_weekday2, 
            'priceSmallVanWeekday3' => $this->price_small_van_weekday3, 

            'priceSmallVanWeekend' => $this->price_small_van_weekend,
            'priceSmallVanWeekend1' => $this->price_small_van_weekend1, 
            'priceSmallVanWeekend2' => $this->price_small_van_weekend2, 
            'priceSmallVanWeekend3' => $this->price_small_van_weekend3,  



            'priceMidVanWeekday' => $this->price_mid_van_weekday,
            'priceMidVanWeekday1' => $this->price_mid_van_weekday1, 
            'priceMidVanWeekday2' => $this->price_mid_van_weekday2, 
            'priceMidVanWeekday3' => $this->price_mid_van_weekday3, 

            'priceMidVanWeekend' => $this->price_mid_van_weekend,
            'priceMidVanWeekend1' => $this->price_mid_van_weekend1, 
            'priceMidVanWeekend2' => $this->price_mid_van_weekend2, 
            'priceMidVanWeekend3' => $this->price_mid_van_weekend3,  

            'priceLargeVanWeekday' => $this->price_large_van_weekday,
            'priceLargeVanWeekday1' => $this->price_large_van_weekday1, 
            'priceLargeVanWeekday2' => $this->price_large_van_weekday2, 
            'priceLargeVanWeekday3' => $this->price_large_van_weekday3, 

            'priceLargeVanWeekend' => $this->price_large_van_weekend,
            'priceLargeVanWeekend1' => $this->price_large_van_weekend1, 
            'priceLargeVanWeekend2' => $this->price_large_van_weekend2, 
            'priceLargeVanWeekend3' => $this->price_large_van_weekend3, 

            'priceGiantVanWeekday' => $this->price_giant_van_weekday,
            'priceGiantVanWeekday1' => $this->price_giant_van_weekday1, 
            'priceGiantVanWeekday2' => $this->price_giant_van_weekday2, 
            'priceGiantVanWeekday3' => $this->price_giant_van_weekday3, 

            'priceGiantVanWeekend' => $this->price_giant_van_weekend,
            'priceGiantVanWeekend1' => $this->price_giant_van_weekend1, 
            'priceGiantVanWeekend2' => $this->price_giant_van_weekend2, 
            'priceGiantVanWeekend3' => $this->price_giant_van_weekend3,

            'priceStop' => $this->price_stop,
            'priceMile' => $this->price_mile,
            'priceStairs' => $this->price_stairs
            
            
        ];
    }
}
