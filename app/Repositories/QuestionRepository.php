<?php

/**
 * Created by PhpStorm.
 * User: BiggerDong
 * Date: 2017/8/3
 * Time: 10:16
 */
namespace App\Repositories;


use App\Question;
use App\Topic;

class QuestionRepository
{
    public function byQId($id)
    {
        return Question::where('qid',$id)->first();
    }

    public function byId($id)
    {
        return Question::find($id);
    }

    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    public function byIdWithTopics($id)
    {
        return Question::where('qid',$id)->with(['topics'])->first();
    }

    public function getQuestionsFeed()
    {
        return Question::published()->latest('created_at')->with(['user','answers','topics'])->paginate(20);
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic) {
           Topic::find($topic)->increment('questions_count');
           return (int) $topic;
        })->toArray();
    }

}