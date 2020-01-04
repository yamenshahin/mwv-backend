<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DynamicPageMeta extends Model
{
    protected $fillable = ['page_id', 'key', 'value'];
    public $timestamps = false;
    /**
     * Define and get meta's job
     *
     * @return mixed
     */
    public function dynamic_page() {
        return $this->belongsTo('App\DynamicPage');
    }
}
