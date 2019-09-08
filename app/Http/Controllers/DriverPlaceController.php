<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DriverPlaceSearchRequest;
Use App\DriverPlace;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\DriverPlace as DriverPlaceResource;

class DriverPlaceController extends Controller
{
    /**
     * Search for places of driver based on distance from lat and lng
     *
     * @param DriverPlaceSearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(DriverPlaceSearchRequest $request)
    {
        //Haversine formula https://en.wikipedia.org/wiki/Haversine_formula
        //http://www.movable-type.co.uk/scripts/latlong.html
        //https://developers.google.com/maps/solutions/store-locator/clothing-store-locator
        $haversineFormula= '*, (`distance` - (3959 * acos(cos(radians('.$request->collectionLat.')) * cos(radians(lat)) * cos(radians(lng) - radians('.$request->collectionLng.')) + sin(radians('.$request->collectionLat.')) * sin(radians(lat))))) AS center_distance';
        
        //Get the Van Size, Weekday, Helpers, db columns name for specific (day, van size and number of helpers)
        $vanSizeWeekdayHelpersOption = $this->vanSizeWeekdayHelpersOption($request);


        $driverPlace = DriverPlace::select(DB::raw($haversineFormula))
        ->where($vanSizeWeekdayHelpersOption, '>', '0')
        ->having('center_distance', '>=', 0)
        ->get();
        

        return DriverPlaceResource::collection($driverPlace)->additional([
            'job_meta' => [
                'collectionPostcode' => $request->collectionPostcode,
                'collectionStreetAddress' => $request->collectionStreetAddress,
                'collectionCity' => $request->collectionCity,
                'collectionLat' => $request->collectionLat,
                'collectionLng' => $request->collectionLng,
                'collectionStairs' => $request->collectionStairs,
                'deliveryPostcode' => $request->deliveryPostcode,
                'deliveryStreetAddress' => $request->deliveryStreetAddress,
                'deliveryLat' => $request->deliveryLat,
                'deliveryLng' => $request->deliveryLng,
                'deliveryStairs' => $request->deliveryStairs,
                'customerInfoName' => $request->customerInfoName,
                'customerInfoEmail' => $request->customerInfoEmail,
                'customerInfoPhone' => $request->customerInfoPhone,
                'vanSize' => $request->vanSize,
                'helpersRequired' => $request->helpersRequired,
                'movingDate' => $request->movingDate,
                'notification' => $request->notification,
                'travelTime' => $request->travelTime,
                'totalTime' => $request->totalTime,
                'weekDay' => $request->weekDay
            ],
        ]);
    }

    /**
     * Get the Van Size, Weekday, Helpers, db columns name for specific (day, van size and number of helpers) 
     *
     * @return string
     */
    public function vanSizeWeekdayHelpersOption($request) 
    {
        $vanSizeWeekdayHelpersOption = '';
        if($request->weekDay == 'weekday') {
            if ($request->vanSize == 1) {
                if ($request->helpersRequired == 0) {
                    $vanSizeWeekdayHelpersOption = 'price_small_van_weekday';
                } elseif ($request->helpersRequired == 1) {
                    $vanSizeWeekdayHelpersOption = 'price_small_van_weekday1';
                } elseif ($request->helpersRequired == 2) {
                    $vanSizeWeekdayHelpersOption = 'price_small_van_weekday2';
                } elseif ($request->helpersRequired == 3) {
                    $vanSizeWeekdayHelpersOption = 'price_small_van_weekday3';
                }
            } elseif ($request->vanSize == 2) {
                if ($request->helpersRequired == 0) {
                    $vanSizeWeekdayHelpersOption = 'price_mid_van_weekday';
                } elseif ($request->helpersRequired == 1) {
                    $vanSizeWeekdayHelpersOption = 'price_mid_van_weekday1';
                } elseif ($request->helpersRequired == 2) {
                    $vanSizeWeekdayHelpersOption = 'price_mid_van_weekday2';
                } elseif ($request->helpersRequired == 3) {
                    $vanSizeWeekdayHelpersOption = 'price_mid_van_weekday3';
                }
            } elseif ($request->vanSize == 3) {
                if ($request->helpersRequired == 0) {
                    $vanSizeWeekdayHelpersOption = 'price_large_van_weekday';
                } elseif ($request->helpersRequired == 1) {
                    $vanSizeWeekdayHelpersOption = 'price_large_van_weekday1';
                } elseif ($request->helpersRequired == 2) {
                    $vanSizeWeekdayHelpersOption = 'price_large_van_weekday2';
                } elseif ($request->helpersRequired == 3) {
                    $vanSizeWeekdayHelpersOption = 'price_large_van_weekday3';
                }
            } elseif ($request->vanSize == 4) {
                if ($request->helpersRequired == 0) {
                    $vanSizeWeekdayHelpersOption = 'price_giant_van_weekday';
                } elseif ($request->helpersRequired == 1) {
                    $vanSizeWeekdayHelpersOption = 'price_giant_van_weekday1';
                } elseif ($request->helpersRequired == 2) {
                    $vanSizeWeekdayHelpersOption = 'price_giant_van_weekday2';
                } elseif ($request->helpersRequired == 3) {
                    $vanSizeWeekdayHelpersOption = 'price_giant_van_weekday3';
                }
            } 
        } elseif ($request->weekDay == 'weekend') {
            if ($request->vanSize == 1) {
                if ($request->helpersRequired == 0) {
                    $vanSizeWeekdayHelpersOption = 'price_small_van_weekend';
                } elseif ($request->helpersRequired == 1) {
                    $vanSizeWeekdayHelpersOption = 'price_small_van_weekend1';
                } elseif ($request->helpersRequired == 2) {
                    $vanSizeWeekdayHelpersOption = 'price_small_van_weekend2';
                } elseif ($request->helpersRequired == 3) {
                    $vanSizeWeekdayHelpersOption = 'price_small_van_weekend3';
                }
            } elseif ($request->vanSize == 2) {
                if ($request->helpersRequired == 0) {
                    $vanSizeWeekdayHelpersOption = 'price_mid_van_weekend';
                } elseif ($request->helpersRequired == 1) {
                    $vanSizeWeekdayHelpersOption = 'price_mid_van_weekend1';
                } elseif ($request->helpersRequired == 2) {
                    $vanSizeWeekdayHelpersOption = 'price_mid_van_weekend2';
                } elseif ($request->helpersRequired == 3) {
                    $vanSizeWeekdayHelpersOption = 'price_mid_van_weekend3';
                }
            } elseif ($request->vanSize == 3) {
                if ($request->helpersRequired == 0) {
                    $vanSizeWeekdayHelpersOption = 'price_large_van_weekend';
                } elseif ($request->helpersRequired == 1) {
                    $vanSizeWeekdayHelpersOption = 'price_large_van_weekend1';
                } elseif ($request->helpersRequired == 2) {
                    $vanSizeWeekdayHelpersOption = 'price_large_van_weekend2';
                } elseif ($request->helpersRequired == 3) {
                    $vanSizeWeekdayHelpersOption = 'price_large_van_weekend3';
                }
            } elseif ($request->vanSize == 4) {
                if ($request->helpersRequired == 0) {
                    $vanSizeWeekdayHelpersOption = 'price_giant_van_weekend';
                } elseif ($request->helpersRequired == 1) {
                    $vanSizeWeekdayHelpersOption = 'price_giant_van_weekend1';
                } elseif ($request->helpersRequired == 2) {
                    $vanSizeWeekdayHelpersOption = 'price_giant_van_weekend2';
                } elseif ($request->helpersRequired == 3) {
                    $vanSizeWeekdayHelpersOption = 'price_giant_van_weekend3';
                }
            }
        }

        return $vanSizeWeekdayHelpersOption;
    }
}
