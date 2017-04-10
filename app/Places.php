<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    protected $table = 'places';

    protected $fillable = [
        'lat', 'lng', 'name', 'original_place_id', 'user_id', 'type',
    ];
}
