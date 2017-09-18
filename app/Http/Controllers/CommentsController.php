<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Repositories\AnswerRepository;
use App\Repositories\CommentRepository;
use Auth;

class CommentsController extends Controller
{
    protected $answer;
    protected $comment;

    /**
     * CommentsController constructor.
     * @param $answer
     * @param $comment
     */
    public function __construct(AnswerRepository $answer, CommentRepository $comment)
    {
        $this->answer = $answer;
        $this->comment = $comment;
    }

    public function answer($id)
    {
        return $this->answer->getAnwserCommentsById($id);
    }

    public function store(StoreCommentRequest $request)
    {
        return $this->comment->create([
            'user_id' => Auth::guard('api')->user()->id,
            'answer_id' => request('answer'),
            'body' => $request->get('body')
        ]);
    }


}
