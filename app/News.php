<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class News extends Model
{
	use Searchable;

    protected $table = 'news';

    protected $fillable = [
        'title', 'sub_title', 'status_id', 'audio_path', 'place_id', 'user_id', 'audio_text', 'publish_time',
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'title';
    }

    public function hasApprove()
    {
    	return $this->publish_time >= \Carbon\Carbon::now();
    }

    public function getManager()
    {
        $place = \App\Places::where('place_id', $this->id);
        $type = $place->type;

        switch ($type) {
            case 'city':
                $city = \App\City::find($place->original_place_id);
                $managerId = $city->supervisor;
                break;

            case 'county':
                $county = \App\County::find($place->original_place_id);
                $managerId = $county->supervisor;
                break;

            case 'guild':
                $guild = \App\Guild::find($place->original_place_id);
                $managerId = $guild->supervisor;
                break;
                
            default:
                # code...
                break;
        }

        return $managerId;
    }

    public function getTotalRecords()
    {
    	return $this->count();
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id', 'status_id');
    }
}
