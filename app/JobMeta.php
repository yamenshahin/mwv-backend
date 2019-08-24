<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobMeta extends Model
{
    protected $fillable = ['key', 'value'];
    
    /**
     * Define and get meta's job
     *
     * @return mixed
     */
    public function metaJob() {
        return $this->belongsTo('App\Job');
    }
}
