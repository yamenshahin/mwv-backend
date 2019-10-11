<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    /**
     * Define and get file's user
     *
     * @return mixed
     */
    public function user() {
        return $this->belongsTo('App\User');
    }
}
