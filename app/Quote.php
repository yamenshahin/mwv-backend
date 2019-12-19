<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /**
     * Define and get job's meta
     *
     * @return mixed
     */
    public function metas() {
        return $this->hasMany('App\QuoteMeta');
    }  
}
