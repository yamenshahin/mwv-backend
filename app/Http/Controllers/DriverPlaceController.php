<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DriverPlaceSearchRequest;
use App\Http\Requests\DriverPlaceRequest;
Use App\DriverPlace;
Use App\PlaceReservation;
Use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\DriverPlaceSearch as DriverPlaceSearchResource;
use App\Http\Resources\DriverPlacePrice as DriverPlacePriceResource;
use App\Http\Resources\DriverPlaceLegal as DriverPlaceLegalResource;
use App\Http\Resources\DriverPlaceLocation as DriverPlaceLocationResource;
use App\Http\Resources\AllPlaces as AllPlacesResource;

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
        
        // Select only active driver
        $active_drivers = User::where('status', '=', 'active')->pluck('id')->all();
        
        $haversineFormula= '*, (`distance` - (3959 * acos(cos(radians('.$request->collection['lat'].')) * cos(radians(lat)) * cos(radians(lng) - radians('.$request->collection['lng'].')) + sin(radians('.$request->collection['lat'].')) * sin(radians(lat))))) AS center_distance';
        
        //Get the Van Size, Weekday, Helpers, db columns name for specific (day, van size and number of helpers)
        $vanSizeWeekdayHelpersOption = $this->vanSizeWeekdayHelpersOption($request);
        
        // Get date_in and date_out
        $date_in = strtotime($request->movingDate) - 7200;
        $date_in = date("Y-m-d H:i:s", $date_in);
        $date_out = strtotime($request->movingDate) + 7200 + $request->totalTime * 3600;
        $date_out = date("Y-m-d H:i:s", $date_out);
        
        //Select occupied/reserved driver places at specific Date In and Date Out
        $reservedDriverPlaceId = PlaceReservation::select('place_id')
        ->where(function($query) use ($date_in, $date_out){
            $query->whereBetween('date_in', [$date_in, $date_out])
            ->orWhereBetween('date_out', [$date_in, $date_out]); 
        })
        ->pluck('place_id')->all();


        $driverPlace = DriverPlace::select(DB::raw($haversineFormula))
        ->whereIn('user_id', $active_drivers)
        ->whereNotIn('id', $reservedDriverPlaceId)
        ->where($vanSizeWeekdayHelpersOption, '>', '0')
        ->having('center_distance', '>=', 0)
        ->get();
        

        return DriverPlaceSearchResource::collection($driverPlace)->additional([
            'job_meta' => [
                'collection' => $request->collection,
                'delivery' => $request->delivery,
                'waypoints' => $request->waypoints,
                'movingDate' => $request->movingDate,
                'dateIn' => $date_in,
                'dateOut' => $date_out,
                'vanSize' => $request->vanSize,
                'helpersRequired' => $request->helpersRequired,
                'description' => $request->description,
                'customerInfoName' => $request->customerInfoName,
                'customerInfoEmail' => $request->customerInfoEmail,
                'customerInfoPhone' => $request->customerInfoPhone,
                'notification' => $request->notification,
                'loadingUnloadingTime' => $request->loadingUnloadingTime,
                'travelTime' => $request->travelTime,
                'totalTime' => $request->totalTime,
                'milesDriven' => round($request->milesDriven,2),
                'stairsTime' => $request->stairsTime,
                'estimatedTotalTime' => $request->estimatedTotalTime,
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
        if($request->weekDay != 0) {
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
        } else {
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

    /**
     * Insert Prices info for places of driver 
     *
     * @param DriverPlaceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function createOrUpdatePrice(DriverPlaceRequest $request) {
        
        $existingDriverPlace =  $this->read($request);
        
        if(!$existingDriverPlace) {
            $driverPlace = new driverPlace;
            $driverPlace->user()->associate($request->user());

        
            $driverPlace->price_small_van_weekday = $request->priceSmallVanWeekday;
            $driverPlace->price_small_van_weekday1 = $request->priceSmallVanWeekday1; 
            $driverPlace->price_small_van_weekday2 = $request->priceSmallVanWeekday2; 
            $driverPlace->price_small_van_weekday3 = $request->priceSmallVanWeekday3; 

            $driverPlace->price_small_van_weekend = $request->priceSmallVanWeekend;
            $driverPlace->price_small_van_weekend1 = $request->priceSmallVanWeekend1; 
            $driverPlace->price_small_van_weekend2 = $request->priceSmallVanWeekend2; 
            $driverPlace->price_small_van_weekend3 = $request->priceSmallVanWeekend3;  



            $driverPlace->price_mid_van_weekday = $request->priceMidVanWeekday;
            $driverPlace->price_mid_van_weekday1 = $request->priceMidVanWeekday1; 
            $driverPlace->price_mid_van_weekday2 = $request->priceMidVanWeekday2; 
            $driverPlace->price_mid_van_weekday3 = $request->priceMidVanWeekday3; 

            $driverPlace->price_mid_van_weekend = $request->priceMidVanWeekend;
            $driverPlace->price_mid_van_weekend1 = $request->priceMidVanWeekend1; 
            $driverPlace->price_mid_van_weekend2 = $request->priceMidVanWeekend2; 
            $driverPlace->price_mid_van_weekend3 = $request->priceMidVanWeekend3;  

            $driverPlace->price_large_van_weekday = $request->priceLargeVanWeekday;
            $driverPlace->price_large_van_weekday1 = $request->priceLargeVanWeekday1; 
            $driverPlace->price_large_van_weekday2 = $request->priceLargeVanWeekday2; 
            $driverPlace->price_large_van_weekday3 = $request->priceLargeVanWeekday3; 

            $driverPlace->price_large_van_weekend = $request->priceLargeVanWeekend;
            $driverPlace->price_large_van_weekend1 = $request->priceLargeVanWeekend1; 
            $driverPlace->price_large_van_weekend2 = $request->priceLargeVanWeekend2; 
            $driverPlace->price_large_van_weekend3 = $request->priceLargeVanWeekend3; 

            $driverPlace->price_giant_van_weekday = $request->priceGiantVanWeekday;
            $driverPlace->price_giant_van_weekday1 = $request->priceGiantVanWeekday1; 
            $driverPlace->price_giant_van_weekday2 = $request->priceGiantVanWeekday2; 
            $driverPlace->price_giant_van_weekday3 = $request->priceGiantVanWeekday3; 

            $driverPlace->price_giant_van_weekend = $request->priceGiantVanWeekend;
            $driverPlace->price_giant_van_weekend1 = $request->priceGiantVanWeekend1; 
            $driverPlace->price_giant_van_weekend2 = $request->priceGiantVanWeekend2; 
            $driverPlace->price_giant_van_weekend3 = $request->priceGiantVanWeekend3;

            $driverPlace->price_stop = $request->priceStop;
            $driverPlace->price_mile = $request->priceMile;
            $driverPlace->price_stairs = $request->priceStairs;
                        
            $driverPlace->save();
            
            return new DriverPlacePriceResource($driverPlace);
        } else {
            
            $existingDriverPlace->price_small_van_weekday = $request->priceSmallVanWeekday;
            $existingDriverPlace->price_small_van_weekday1 = $request->priceSmallVanWeekday1; 
            $existingDriverPlace->price_small_van_weekday2 = $request->priceSmallVanWeekday2; 
            $existingDriverPlace->price_small_van_weekday3 = $request->priceSmallVanWeekday3; 

            $existingDriverPlace->price_small_van_weekend = $request->priceSmallVanWeekend;
            $existingDriverPlace->price_small_van_weekend1 = $request->priceSmallVanWeekend1; 
            $existingDriverPlace->price_small_van_weekend2 = $request->priceSmallVanWeekend2; 
            $existingDriverPlace->price_small_van_weekend3 = $request->priceSmallVanWeekend3;  



            $existingDriverPlace->price_mid_van_weekday = $request->priceMidVanWeekday;
            $existingDriverPlace->price_mid_van_weekday1 = $request->priceMidVanWeekday1; 
            $existingDriverPlace->price_mid_van_weekday2 = $request->priceMidVanWeekday2; 
            $existingDriverPlace->price_mid_van_weekday3 = $request->priceMidVanWeekday3; 

            $existingDriverPlace->price_mid_van_weekend = $request->priceMidVanWeekend;
            $existingDriverPlace->price_mid_van_weekend1 = $request->priceMidVanWeekend1; 
            $existingDriverPlace->price_mid_van_weekend2 = $request->priceMidVanWeekend2; 
            $existingDriverPlace->price_mid_van_weekend3 = $request->priceMidVanWeekend3;  

            $existingDriverPlace->price_large_van_weekday = $request->priceLargeVanWeekday;
            $existingDriverPlace->price_large_van_weekday1 = $request->priceLargeVanWeekday1; 
            $existingDriverPlace->price_large_van_weekday2 = $request->priceLargeVanWeekday2; 
            $existingDriverPlace->price_large_van_weekday3 = $request->priceLargeVanWeekday3; 

            $existingDriverPlace->price_large_van_weekend = $request->priceLargeVanWeekend;
            $existingDriverPlace->price_large_van_weekend1 = $request->priceLargeVanWeekend1; 
            $existingDriverPlace->price_large_van_weekend2 = $request->priceLargeVanWeekend2; 
            $existingDriverPlace->price_large_van_weekend3 = $request->priceLargeVanWeekend3; 

            $existingDriverPlace->price_giant_van_weekday = $request->priceGiantVanWeekday;
            $existingDriverPlace->price_giant_van_weekday1 = $request->priceGiantVanWeekday1; 
            $existingDriverPlace->price_giant_van_weekday2 = $request->priceGiantVanWeekday2; 
            $existingDriverPlace->price_giant_van_weekday3 = $request->priceGiantVanWeekday3; 

            $existingDriverPlace->price_giant_van_weekend = $request->priceGiantVanWeekend;
            $existingDriverPlace->price_giant_van_weekend1 = $request->priceGiantVanWeekend1; 
            $existingDriverPlace->price_giant_van_weekend2 = $request->priceGiantVanWeekend2; 
            $existingDriverPlace->price_giant_van_weekend3 = $request->priceGiantVanWeekend3;

            $existingDriverPlace->price_stop = $request->priceStop;
            $existingDriverPlace->price_mile = $request->priceMile;
            $existingDriverPlace->price_stairs = $request->priceStairs;
            

            $existingDriverPlace->save();
            return new DriverPlacePriceResource($existingDriverPlace);
        }
        

    }
    
    /**
     * Insert Prices info for places of driver 
     *
     * @param DriverPlaceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function createOrUpdateLegal(DriverPlaceRequest $request) {
        
        $existingDriverPlace =  $this->read($request);
        
        
        if(!$existingDriverPlace) {
            $driverPlace = new driverPlace;
            $driverPlace->user()->associate($request->user());

        
            $driverPlace->vehicle_registration = $request->vehicleRegistration;
            $driverPlace->national_insurance_number = 'Not provided';
            $driverPlace->driving_licence_number = $request->drivingLicenceNumber;
            $driverPlace->disc = $request->disc;
            
            $driverPlace->save();
            
            return new DriverPlaceLegalResource($driverPlace);
        } else {
            $existingDriverPlace->vehicle_registration = $request->vehicleRegistration;
            $existingDriverPlace->national_insurance_number = 'Not provided';
            $existingDriverPlace->driving_licence_number = $request->drivingLicenceNumber;
            $existingDriverPlace->disc = $request->disc;
            

            $existingDriverPlace->save();
            
            return new DriverPlaceLegalResource($existingDriverPlace);
        }
        

    }
    
    /**
     * Read driver place info
     *
     * @param DriverPlaceRequest $request
     * @return JSON
     */
    public function read(DriverPlaceRequest $request) {
        $driverPlace = DriverPlace::select('*')
        ->where('user_id', '=', $request->user()->id)
        ->first();
        return $driverPlace;
    }

    /**
     * Get Prices info for driver places
     *
     * @param DriverPlaceRequest $request
     * @return JSON
     */
    public function getPrice(DriverPlaceRequest $request) {
        $driverPlace =  $this->read($request);
        //If there is no driver place just create a default one
        if(!$driverPlace) {
            $driverPlace = new driverPlace;
            $driverPlace->user()->associate($request->user());
            $driverPlace->save();
        }
        return new DriverPlacePriceResource($driverPlace);
    }

    /**
     * Get Legal info for driver places
     *
     * @param DriverPlaceRequest $request
     * @return JSON
     */
    public function getLegal(DriverPlaceRequest $request) {
        $driverPlace =  $this->read($request);
        //If there is no driver place just create a default one
        if(!$driverPlace) {
            $driverPlace = new driverPlace;
            $driverPlace->user()->associate($request->user());
            $driverPlace->save();
        }
        return new DriverPlaceLegalResource($driverPlace);
    }

    /**
     * Create or update driver location info (e.g. lat, lng)
     *
     * @param DriverPlaceRequest $request
     * @return JSON
     */
    public function createOrUpdateLocation(DriverPlaceRequest $request) {
        $existingDriverPlace =  $this->read($request);
        
        if(!$existingDriverPlace) {
            $driverPlace = new driverPlace;
            $driverPlace->user()->associate($request->user());

            $driverPlace->address = $request->address;
            $driverPlace->city = $request->city;
            $driverPlace->postcode = $request->postcode;
            $driverPlace->lat = $request->lat;
            $driverPlace->lng = $request->lng;
            $driverPlace->distance = $request->distance;
            

            $driverPlace->save();
            
            return new DriverPlaceLocationResource($driverPlace);
        } else {
            $existingDriverPlace->address = $request->address;
            $existingDriverPlace->postcode = $request->postcode;
            $existingDriverPlace->city = $request->city;
            $existingDriverPlace->lat = $request->lat;
            $existingDriverPlace->lng = $request->lng;
            $existingDriverPlace->distance = $request->distance;
            
            $existingDriverPlace->save();
            return new DriverPlaceLocationResource($existingDriverPlace);
        }
    }

    /**
     * Get Location info for driver places
     *
     * @param DriverPlaceRequest $request
     * @return JSON
     */
    public function getLocation(DriverPlaceRequest $request) {
        $driverPlace =  $this->read($request);
        return new DriverPlaceLocationResource($driverPlace);
    }

    /**
     * Get all places lat and lng
     *
     * @return JSON
     */
    public function getAllPlaces() {
        $places = DriverPlace::select('*')
        ->get();
        return AllPlacesResource::collection($places);
    }

}
