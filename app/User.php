<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role_id === config('attribute.role.admin');
    }

    public function isPeople()
    {
        return $this->role_id === config('attribute.role.people');
    }

    public function isCreater()
    {
        return $this->role_id === config('attribute.role.creater');
    }
    public function isApprover()
    {
        return $this->role_id === config('attribute.role.approver');
    }

    public function isUsersManager()
    {
        return $this->role_id === config('attribute.role.users_manager');
    }

    public function isReflectedManager()
    {
        return $this->role_id === config('attribute.role.reflect_manager');
    }

}
