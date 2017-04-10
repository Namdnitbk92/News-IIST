<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title', 'sub_title', 'status_id', 'audio_path', 'place_id', 'user_id'
    ];

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id', 'status_id');
    }
}
