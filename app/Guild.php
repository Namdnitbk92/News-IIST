<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    protected $table = 'guild';

    public function county()
    {
        return $this->belongsTo('App\County');
    }
}
