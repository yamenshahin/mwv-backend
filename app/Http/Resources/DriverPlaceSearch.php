<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserSimple as UserSimpleResource;
use App\User;
use App\Http\Controllers\PriceBreakdown;
Use App\UserFile;
use App\Http\Resources\UserFile as UserFileResource;
class DriverPlaceSearch extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $priceBreakdown = new PriceBreakdown($request, $this);
        $priceBreakdownDetails = $priceBreakdown->priceBreakdown();
        
        //If the service available ex: work on weekend with 2 helpers
        if ($priceBreakdownDetails['totalTimePrice'] != 0) {
            if($this->votes === 0) {
                $score = 0;
            } else {
                $score = $this->stars / $this->votes;
            }
            return [
                'placeId' => $this->id,
                'disc' => $this->disc,
                'user' => UserSimpleResource::make(User::find($this->user_id)),
                'placeFile' => UserFileResource::make( UserFile::select('*')
                ->where([
                    ['user_id', '=', $this->user_id],
                    ['key', '=', 'places'],
                ])
                ->first()),
                'milesDriven' => $this->miles_driven,
                'jobsBooked' => $this->jobs_booked,
                
                'score' => $score,
                'votes' => $this->votes,

                'total' => $priceBreakdownDetails['total'],
                
                'price' => $priceBreakdownDetails
                
            ];
        }
    }
}
