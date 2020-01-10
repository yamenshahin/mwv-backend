<?php

namespace App\Http\Controllers;

use App\PlaceReservation;
use Illuminate\Http\Request;

class PlaceReservationController extends Controller
{
    public static function store($place_id, $date_in, $date_out) 
    {
        $place_reservation = new PlaceReservation();
        $place_reservation->place_id = $place_id;
        $place_reservation->date_in = $date_in;
        $place_reservation->date_out = $date_out;

        $place_reservation->save();
    }
}
