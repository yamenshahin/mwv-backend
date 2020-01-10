<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    protected $fillable = ['page', 'slug'];

    /**
     * Define and get job's meta
     *
     * @return mixed
     */
    public function meta() {
        return $this->hasMany('App\DynamicPageMeta');
    }
}
