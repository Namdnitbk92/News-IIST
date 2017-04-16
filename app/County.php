<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $table = 'county';

    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'supervisor', 'id');
    }
}
