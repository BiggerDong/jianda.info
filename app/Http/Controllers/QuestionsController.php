<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Question;
use App\Repositories\QuestionRepository;
use App\Topic;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class QuestionsController extends Controller
{
    protected $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except('index','show','warning','search');
        $this->questionRepository = $questionRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionsFeed();

        $judge = 1;
        if (Auth::check() && Auth::user()->auth_type == null && Auth::user()->is_active == 0) {
            $judge = 0;
        }
        return view('home',compact('questions','judge'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        $data = [
            'qid' => time().rand(10000,99999),
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ];
        $question = $this->questionRepository->create($data);
        $question->user()->increment('questions_count');
        Auth::user()->follows()->toggle($question->id);
        $question->topics()->attach($topics);
        //清空Redis内容
        Redis::flushdb();
        return redirect()->route('questionshow',[$question->qid]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $qid
     * @return \Illuminate\Http\Response
     */
    public function show($question,Request $request)
    {
        $question = $this->questionRepository->byIdWithTopics($question);
        $question->increment('pv');
        if ($request->query('sort') == 'created') {
            return view('questions.showSort',compact('question'));
        }
        return view('questions.show',compact('question'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byQId($id);
        if (Auth::user()->owns($question)) {
            return view('questions.edit',compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $question = $this->questionRepository->byQId($id);
        $question->update([
            'title' => $request->get('title'),
            'body'  => $request->get('body')
        ]);
        return redirect()->route('questionshow',[$question->qid]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function warning($id)
    {
        $question = $this->questionRepository->byId($id);
        $question->update([
            'is_warning' => 1
        ]);
    }

    public function search(Request $request)
    {
        $questions = Question::search($request->keyword)->paginate(20);
        $count = Question::search($request->keyword)->get()->count();

        return view('questions.search',compact('questions','count'));
    }
}
