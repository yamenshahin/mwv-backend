<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * Define and get job's meta
     *
     * @return mixed
     */
    public function jobMeta() {
        return $this->hasMany('App\JobMeta');
    }

    /**
     * Define and get job's user
     *
     * @return mixed
     */
    public function jobUser() {
        return $this->belongsTo('App\User');
    }
}
