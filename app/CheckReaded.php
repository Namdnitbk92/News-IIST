<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckReaded extends Model
{
    protected $table = 'check_readed';

    protected $fillable = [
        'new_id', 'user_id', 'is_readed',
    ];
}
