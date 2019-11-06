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
            'collection.address' => 'required',
            'delivery.address' => 'required',
            'vanSize' => 'required',
            'movingDate' => 'required',
            'helpersRequired' => 'required',
            'customerInfoName' => 'required',
            'customerInfoEmail' => 'required|email',
            'customerInfoPhone' => 'required',
            'notification' => 'required',
            'loadingUnloadingTime' => 'required',
            'travelTime' => 'required',
            'totalTime' => 'required',
            'milesDriven' => 'required',
            'stairsTime' => 'required',
            'estimatedTotalTime' => 'required',
            'weekDay' => 'required'
        ];
    }
}
