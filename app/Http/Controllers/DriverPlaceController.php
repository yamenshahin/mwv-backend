<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DriverPlaceRequest;

class DriverPlaceController extends Controller
{
    public function search(DriverPlaceRequest $request)

    
    {
        return [
            'message' => 'Work DriverPlaceController'
        ];
    }
}
