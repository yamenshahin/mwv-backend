<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobMeta extends Model
{
    /**
     * Define and get meta's job
     *
     * @return mixed
     */
    public function job() {
        return $this->hasOne('App\Job');
    }
}
