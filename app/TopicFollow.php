<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicFollow extends Model
{
    protected $table = 'user_topic';

    protected $fillable = ['user_id','topic_id'];
}
