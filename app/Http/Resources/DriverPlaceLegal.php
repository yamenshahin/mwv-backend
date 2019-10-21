<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\User;

class DriverPlaceLegal extends JsonResource
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
            
            
            'vehicleRegistration' => $this->vehicle_registration,
            'nationalInsuranceNumber' => $this->national_insurance_number, 
            'drivingLicenceNumber' => $this->driving_licence_number, 
            'disc' => $this->disc, 
            
        ];
    }
}
