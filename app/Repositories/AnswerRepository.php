<?php
/**
 * Created by PhpStorm.
 * User: BiggerDong
 * Date: 2017/8/4
 * Time: 17:21
 */

namespace App\Repositories;


use App\Answer;

class AnswerRepository
{
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }

    public function byId($id)
    {
        return Answer::find($id);
    }

    public function getAnwserCommentsById($id)
    {
        $answer = Answer::with('comments','comments.user')->where('id',$id)->first();
        return $answer->comments;
    }
}