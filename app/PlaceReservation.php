<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceReservation extends Model
{
    protected $fillable = ['place_id', 'date_in', 'date_out'];
}
