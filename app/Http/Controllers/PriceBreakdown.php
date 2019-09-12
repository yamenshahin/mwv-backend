<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $vanSizeWeekdayPrice = $this->vanSizeWeekdayPrice();
        $estimatedDistancePrice = $this->request->estimatedDistance * $this->place->price_mile;
        $totalTimePrice = $this->request->totalTime * $vanSizeWeekdayPrice;
        $additionalTimePrice = $vanSizeWeekdayPrice / 2;
        $stairsPrice = ($this->request->collection['stairs'] + $this->request->delivery['stairs']) * $this->place->price_stairs;

        $subtotal = $estimatedDistancePrice + $totalTimePrice + $stairsPrice;
        $fee = $subtotal * 0.07;
        $total = $subtotal + $fee;

        return [
            'estimatedDistancePrice' => $estimatedDistancePrice,
            'totalTimePrice' => $totalTimePrice,
            'additionalTimePrice' => $additionalTimePrice,
            'stairsPrice' => $stairsPrice,
            'subtotal' => $subtotal,
            'fee' => $fee,
            'total' => $total
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
        if($this->request->weekDay == 'weekday') {
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
        } elseif ($this->request->weekDay == 'weekend') {
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
