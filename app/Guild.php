<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    protected $table = 'guild';

    protected $fillable = [
        'name', 'county_id', 'status_id', 'supervisor',
    ];

    public function county()
    {
        return $this->belongsTo('App\County');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'supervisor', 'id');
    }
}
