<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersAccount extends Model
{
    protected $table = 'users_account';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_name', 'password', 'description',
    ];
}
