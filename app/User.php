<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable;
    use Searchable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'address', 'role_id', 'original_place_id', 'belong_to_place',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'email';
    }

    public function isAdmin()
    {
        return $this->role_id === config('attribute.role.admin')."";
    }

    public function isPeople()
    {
        return $this->role_id === config('attribute.role.people')."";
    }

    public function isCreater()
    {
        return $this->role_id === config('attribute.role.creater')."";
    }
    public function isApprover()
    {
        return $this->role_id === config('attribute.role.approver')."";
    }

    public function isUsersManager()
    {
        return $this->role_id === config('attribute.role.users_manager')."";
    }

    public function isReflectedManager()
    {
        return $this->role_id === config('attribute.role.reflect_manager')."";
    }

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'role_id');
    }
}
