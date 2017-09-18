<?php

namespace App\Http\Controllers;

use App\Notifications\NewQuestionFollowNotification;
use App\Repositories\QuestionRepository;
use App\User;
use Illuminate\Http\Request;
use Auth;

class QuestionFollowController extends Controller
{
    protected $questionRepository;

    /**
     * QuestionFollowController constructor.
     * @param $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth');
        $this->questionRepository = $questionRepository;
    }

    public function isFollowed(Request $request)
    {
        if (Auth::guard('api')->user()->followed($request->get('question'))){
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function followThisQuestion(Request $request)
    {
        $me = Auth::guard('api')->user();
        $question = $this->questionRepository->byId($request->get('question'));
        $userToFollow = $question->user()->first();
        $followed = Auth::guard('api')->user()->followThisQ($question->id);
        if (count($followed['detached']) > 0){
            $question->decrement('followers_count');
            $me->decrement('follow_questions_count');
            return response()->json(['followed' => false]);
        }
        $userToFollow->notify(new NewQuestionFollowNotification($question));
        $question->increment('followers_count');
        $me->increment('follow_questions_count');
        return response()->json(['followed' => true]);
    }


}
