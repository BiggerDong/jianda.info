<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['tid','name', 'describe','questions_count','followers_count'];

    public function questions()
    {
        return $this->belongsToMany('App\Question')->withTimestamps();
    }
}
