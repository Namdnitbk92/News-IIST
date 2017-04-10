<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';

    public function county()
    {
        return $this->hasMany('App\County');
    }
}
