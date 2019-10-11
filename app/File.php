<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
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
