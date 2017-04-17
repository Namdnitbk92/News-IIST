<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';

     protected $fillable = [
        'name', 'supervisor',
    ];

    public function county()
    {
        return $this->hasMany('App\County');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'supervisor', 'id');
    }
}
