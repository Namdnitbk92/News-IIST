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

    public function getAddressByUser()
    {
        $belong_to_place = $this->belong_to_place;
        $original_place_id = $this->original_place_id;

        switch ($belong_to_place) {
                case 'city':
                    $original_place = \App\City::find($original_place_id);
                    $address = $original_place ? $original_place->name : '';
                    break;
                
                case 'county':
                    $original_place = \App\County::find($original_place_id);
                    if ($original_place)
                    {
                        $address = $original_place->name .' - '. $original_place->city()->first()->name;
                    }
                    break; 

                case 'guild':
                    $original_place = \App\Guild::find($original_place_id);
                    if ($original_place)
                    {
                        $address = $original_place->name .' - '. $original_place->county()->first()->name .' - ' . $original_place->county()->first()->city()->first()->name;
                    }
                    break;   

                default:
                    $address = '';
                    break;
            }

        return $address ?? '';
    }

    public function getListPlaceByUser()
    {
        $belong_to_place = \Auth::user()->belong_to_place;
        $original_place_id = \Auth::user()->original_place_id;

        switch ($belong_to_place) {
            case 'city':
                $cities = \App\City::all();
                $counties = \App\County::all();
                break;

            case 'county':
                $counties = \App\County::where('id', $original_place_id)->get();
                $guilds = \App\Guild::where('county_id', $original_place_id)->get();
                break;
            
            case 'guild':
            
                break;
        }

        return [
            'cities' => isset($cities) ? $cities : [],
            'counties' => isset($counties) ? $counties: [],
            'guilds' => isset($guilds) ? $guilds: [],
        ];
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
