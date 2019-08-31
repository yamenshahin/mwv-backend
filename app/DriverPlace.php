<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverPlace extends Model
{
    /**
     * Define and get driver place's user
     *
     * @return mixed
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}
