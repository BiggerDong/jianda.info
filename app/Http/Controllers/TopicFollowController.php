<?php

namespace App\Http\Controllers;

use App\Repositories\TopicRepository;
use Illuminate\Http\Request;
use Auth;

class TopicFollowController extends Controller
{
    protected $topicRepository;

    /**
     * TopicFollowController constructor.
     * @param $topicRepository
     */
    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    public function isFollowed(Request $request)
    {
        if (Auth::guard('api')->user()->followedt($request->get('topic'))){
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function followThisTopic(Request $request)
    {
        $me = Auth::guard('api')->user();
        $topic = $this->topicRepository->byId($request->get('topic'));
        $followed = Auth::guard('api')->user()->followThisT($topic->id);
        if (count($followed['detached']) > 0){
            $topic->decrement('followers_count');
            $me->decrement('follow_topics_count');
            return response()->json(['followed' => false]);
        }
        $topic->increment('followers_count');
        $me->increment('follow_topics_count');
        return response()->json(['followed' => true]);
    }


}
