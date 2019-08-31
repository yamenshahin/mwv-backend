<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverPlaceSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'collectionPostcode' => 'required',
            'collectionStreetAddress' => 'required',
            'collectionCity' => 'required',
            'collectionLat' => 'required',
            'collectionLng' => 'required',
            'collectionStairs' => 'required',
            'deliveryPostcode' => 'required',
            'deliveryStreetAddress' => 'required',
            'deliveryCity' => 'required',
            'deliveryLat' => 'required',
            'deliveryLng' => 'required',
            'deliveryStairs' => 'required',
            'customerInfoName' => 'required',
            'customerInfoEmail' => 'required',
            'customerInfoPhone' => 'required',
            'vanSize' => 'required',
            'helpersRequired' => 'required',
            'movingDate' => 'required',
            'travelTime' => 'required',
            'totalTime' => 'required',
            'notification' => 'required'
        ];
    }
}
