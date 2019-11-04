<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meta;

class PriceBreakdown extends Controller
{
    public $request;
    public $place;

    public function __construct($request, $place) {
        $this->request = $request;
        $this->place = $place;
    }

    /**
     * Get price breakdown for each place per job requirements
     *
     * @return array
     */
    public function priceBreakdown()
    {
        $default_fee = Meta::select('*')
        ->where('key', '=', 'defaultFee')
        ->first();

        $vanSizeWeekdayPrice = $this->vanSizeWeekdayPrice();

        $estimatedDistancePrice = ($this->request->milesDriven * $this->place->price_mile) 
        + 
        ($this->request->milesDriven * $this->place->price_mile)  * $default_fee->value/100;

        $totalTimePrice = ($this->request->totalTime * $vanSizeWeekdayPrice)
        +
        ($this->request->totalTime * $vanSizeWeekdayPrice)  * $default_fee->value/100;

        $additionalTimePrice = $vanSizeWeekdayPrice / 2;

        $stairsPrice = (($this->request->collection['stairs'] + $this->request->delivery['stairs']) * $this->place->price_stairs) 
        +
        (($this->request->collection['stairs'] + $this->request->delivery['stairs']) * $this->place->price_stairs) * $default_fee->value/100;

        $subtotal = $estimatedDistancePrice + $totalTimePrice + $stairsPrice;
        $total = $subtotal;

        return [
            'milePrice' => $this->place->price_mile,
            'estimatedDistancePrice' => round($estimatedDistancePrice,2),
            'totalTimePrice' => round($totalTimePrice,2),
            'additionalTimePrice' => round($additionalTimePrice,2),
            'stairsPrice' => round($stairsPrice,2),
            'subtotal' => round($subtotal,2),
            'total' => round($total,2)
        ];
    }

    /**
     * Get the price for specific (day, van size and number of helpers) 
     *
     * @return float
     */
    public function vanSizeWeekdayPrice() 
    {
        $vanSizeWeekdayPrice = 0.00;
        if($this->request->weekDay != 0) {
            if ($this->request->vanSize == 1) {
                if ($this->request->helpersRequired == 0) {
                    $vanSizeWeekdayPrice = $this->place->price_small_van_weekday;
                } elseif ($this->request->helpersRequired == 1) {
                    $vanSizeWeekdayPrice = $this->place->price_small_van_weekday1;
                } elseif ($this->request->helpersRequired == 2) {
                    $vanSizeWeekdayPrice = $this->place->price_small_van_weekday2;
                } elseif ($this->request->helpersRequired == 3) {
                    $vanSizeWeekdayPrice = $this->place->price_small_van_weekday3;
                }
            } elseif ($this->request->vanSize == 2) {
                if ($this->request->helpersRequired == 0) {
                    $vanSizeWeekdayPrice = $this->place->price_mid_van_weekday;
                } elseif ($this->request->helpersRequired == 1) {
                    $vanSizeWeekdayPrice = $this->place->price_mid_van_weekday1;
                } elseif ($this->request->helpersRequired == 2) {
                    $vanSizeWeekdayPrice = $this->place->price_mid_van_weekday2;
                } elseif ($this->request->helpersRequired == 3) {
                    $vanSizeWeekdayPrice = $this->place->price_mid_van_weekday3;
                }
            } elseif ($this->request->vanSize == 3) {
                if ($this->request->helpersRequired == 0) {
                    $vanSizeWeekdayPrice = $this->place->price_large_van_weekday;
                } elseif ($this->request->helpersRequired == 1) {
                    $vanSizeWeekdayPrice = $this->place->price_large_van_weekday1;
                } elseif ($this->request->helpersRequired == 2) {
                    $vanSizeWeekdayPrice = $this->place->price_large_van_weekday2;
                } elseif ($this->request->helpersRequired == 3) {
                    $vanSizeWeekdayPrice = $this->place->price_large_van_weekday3;
                }
            } elseif ($this->request->vanSize == 4) {
                if ($this->request->helpersRequired == 0) {
                    $vanSizeWeekdayPrice = $this->place->price_giant_van_weekday;
                } elseif ($this->request->helpersRequired == 1) {
                    $vanSizeWeekdayPrice = $this->place->price_giant_van_weekday1;
                } elseif ($this->request->helpersRequired == 2) {
                    $vanSizeWeekdayPrice = $this->place->price_giant_van_weekday2;
                } elseif ($this->request->helpersRequired == 3) {
                    $vanSizeWeekdayPrice = $this->place->price_giant_van_weekday3;
                }
            } 
        } else {
            if ($this->request->vanSize == 1) {
                if ($this->request->helpersRequired == 0) {
                    $vanSizeWeekdayPrice = $this->place->price_small_van_weekend;
                } elseif ($this->request->helpersRequired == 1) {
                    $vanSizeWeekdayPrice = $this->place->price_small_van_weekend1;
                } elseif ($this->request->helpersRequired == 2) {
                    $vanSizeWeekdayPrice = $this->place->price_small_van_weekend2;
                } elseif ($this->request->helpersRequired == 3) {
                    $vanSizeWeekdayPrice = $this->place->price_small_van_weekend3;
                }
            } elseif ($this->request->vanSize == 2) {
                if ($this->request->helpersRequired == 0) {
                    $vanSizeWeekdayPrice = $this->place->price_mid_van_weekend;
                } elseif ($this->request->helpersRequired == 1) {
                    $vanSizeWeekdayPrice = $this->place->price_mid_van_weekend1;
                } elseif ($this->request->helpersRequired == 2) {
                    $vanSizeWeekdayPrice = $this->place->price_mid_van_weekend2;
                } elseif ($this->request->helpersRequired == 3) {
                    $vanSizeWeekdayPrice = $this->place->price_mid_van_weekend3;
                }
            } elseif ($this->request->vanSize == 3) {
                if ($this->request->helpersRequired == 0) {
                    $vanSizeWeekdayPrice = $this->place->price_large_van_weekend;
                } elseif ($this->request->helpersRequired == 1) {
                    $vanSizeWeekdayPrice = $this->place->price_large_van_weekend1;
                } elseif ($this->request->helpersRequired == 2) {
                    $vanSizeWeekdayPrice = $this->place->price_large_van_weekend2;
                } elseif ($this->request->helpersRequired == 3) {
                    $vanSizeWeekdayPrice = $this->place->price_large_van_weekend3;
                }
            } elseif ($this->request->vanSize == 4) {
                if ($this->request->helpersRequired == 0) {
                    $vanSizeWeekdayPrice = $this->place->price_giant_van_weekend;
                } elseif ($this->request->helpersRequired == 1) {
                    $vanSizeWeekdayPrice = $this->place->price_giant_van_weekend1;
                } elseif ($this->request->helpersRequired == 2) {
                    $vanSizeWeekdayPrice = $this->place->price_giant_van_weekend2;
                } elseif ($this->request->helpersRequired == 3) {
                    $vanSizeWeekdayPrice = $this->place->price_giant_van_weekend3;
                }
            }
        }

        return $vanSizeWeekdayPrice;
    }
}
