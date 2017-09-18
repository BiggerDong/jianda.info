<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Notifications\NewAnswerNotification;
use App\Question;
use App\Repositories\AnswerRepository;
use Auth;
class AnswersController extends Controller
{
    protected $answerRepository;

    /**
     * AnswersController constructor.
     */
    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    public function store(StoreAnswerRequest $request, $question)
    {
        $answer = $this->answerRepository->create([
            'question_id' => $question,
            'user_id' => Auth::id(),
            'body' => $request->get('body'),
            'add' => $request->get('add')
        ]);
        $questionFor = Question::where('id',$question)->first();
        $userToNotify = $questionFor->user()->first();
        $userToNotify->notify(new NewAnswerNotification($questionFor));
        $answer->question()->increment('answers_count');
        $answer->user()->increment('answers_count');
        return back();
    }

}
