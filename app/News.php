<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class News extends Model
{
	use Searchable;

    protected $table = 'news';

    protected $fillable = [
        'title', 'sub_title', 'status_id', 'audio_path', 'place_id', 'user_id', 'audio_text',
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

    public function getTotalRecords()
    {
    	return $this->count();
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id', 'status_id');
    }
}
