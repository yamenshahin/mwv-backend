<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    protected $fillable = ['parent_slug', 'slug'];

    /**
     * Define and get Dynamic Page's meta
     *
     * @return mixed
     */
    public function meta() {
        return $this->hasMany('App\DynamicPageMeta');
    }

    /**
     * Define and get Dynamic Page's files
     *
     * @return mixed
     */
    public function file() {
        return $this->hasMany('App\DynamicPageFile');
    }
}
