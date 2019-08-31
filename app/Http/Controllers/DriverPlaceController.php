<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DriverPlaceSearchRequest;
Use App\DriverPlace;
use Illuminate\Support\Facades\DB;

class DriverPlaceController extends Controller
{
    public function search(DriverPlaceSearchRequest $request)
    {
        $driverPlace = DriverPlace::select(DB::raw('*, (`distance` - (3959 * acos(cos(radians(-33.737885)) * cos(radians(lat)) * cos(radians(lng) - radians(151.235260)) + sin(radians(-33.737885)) * sin(radians(lat))))) AS center_distance'))
        ->having('center_distance', '>=', 0)
        ->get();
        
        return [
            'data' => $driverPlace
        ];
    }
}
