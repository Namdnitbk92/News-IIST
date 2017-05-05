<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class News extends Model
{
	use Searchable;

    protected $table = 'news';

    protected $fillable = [
        'title', 'sub_title', 'status_id', 'audio_path', 'attach_path_file', 'place_id', 'user_id', 'audio_text', 'publish_time', 'file_type', 'reason',
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
        $place = \App\Places::where('place_id', $this->place_id)->first();
        $type = !is_null($place) ? $place->type : null;
        $managerId = null;
        switch ($type) {
            case 'city':
                $city = \App\City::find($place->original_place_id);
                $managerId = isset($city) ? $city->supervisor : null;
                break;

            case 'county':
                $county = \App\County::find($place->original_place_id);
                $managerId = isset($county) ? $county->supervisor : null;

                break;

            case 'guild':
                $guild = \App\Guild::find($place->original_place_id);
                $managerId = isset($guild) ? $guild->supervisor : null;
                break;
        }

        return $managerId;
    }

    public function getTotalRecords()
    {
    	return $this->count();
    }

    public function getTotalRecordsByCreater()
    {
        return $this->where('user_id', \Auth::user()->id)->count();
    }    

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id', 'status_id');
    }
}
