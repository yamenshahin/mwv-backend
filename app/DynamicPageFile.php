<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DynamicPageFile extends Model
{
    protected $fillable = ['page_id', 'key', 'url'];
    public $timestamps = false;
    
    /**
     * Define and get file's dynamic page
     *
     * @return mixed
     */
    public function dynamic_page() {
        return $this->belongsTo('App\DynamicPage');
    }
}
