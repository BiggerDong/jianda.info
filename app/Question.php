<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Question extends Model
{
    protected $fillable = ['qid','title','body','user_id','is_warning'];

    use Searchable;

    public function searchableAs()
    {
        return 'questions_index';
    }

    public function topics()
    {
        return $this->belongsToMany('App\Topic')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function follows()
    {
        return $this->belongsToMany(User::class,'user_question')->withTimestamps();
    }


    public function scopePublished($query)
    {
        return $query->where('is_hidden','F');
    }


}
