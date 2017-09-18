<?php
/**
 * Created by PhpStorm.
 * User: BiggerDong
 * Date: 2017/8/24
 * Time: 19:36
 */

namespace App\Repositories;


use App\Topic;

class TopicRepository
{
    public function byId($id)
    {
       return Topic::find($id);
    }

    public function getCount()
    {
        return Topic::count();
    }

    public function getTopicsFeedPage()
    {
        return Topic::latest()->paginate(20);
    }


    public function getTopic($id)
    {
        return Topic::where('tid',$id)->first();
    }

    public function getTop($id)
    {
        $collect = Topic::orderByDesc('questions_count','followers_count')->get();
        return $collect->where('tid',$id)->keys();
    }

    public function getHots()
    {
        return Topic::orderByDesc('questions_count','followers_count')->take(10)->get();
    }


    public function getQuestionsByTopic($id)
    {
        return $this->getTopic($id)->questions()->latest()->paginate(5);
    }


}