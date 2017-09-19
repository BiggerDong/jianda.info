<?php

namespace App\Http\Controllers;

use App\Repositories\TopicRepository;
use App\Topic;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    protected $topicRepository;

    /**
     * TopicsController constructor.
     * @param $topicRepository
     */
    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    public function index()
    {
        $count = $this->topicRepository->getCount();
        $topics = $this->topicRepository->getTopicsFeedPage();
        $hots = $this->topicRepository->getHots();
        return view('topics.index',compact('count','topics','hots'));
    }

    public function show($id)
    {
        $topic =  $this->topicRepository->getTopic($id);
        $questions = $this->topicRepository->getQuestionsByTopic($id);
        $top = $this->topicRepository->getTop($id);
        $hots = $this->topicRepository->getHots();
        $topicName =  $topic->name;
        foreach ($questions as $question){
            foreach ($question->topics->where('name','!==',$topicName)->all() as $topicFor){
                $topicNameArray[] = $topicFor->name;
                $relation = array_unique($topicNameArray);
            }
        }
        return view('topics.show',compact('topic','questions','top','hots','relation','topicFor'));
    }

    public function store(Request $request)
    {
        $data = [
            'tid' => time().rand(10000,99999),
            'name' => $request->get('name'),
        ];

        Topic::create($data);
        return redirect('/topics');

    }
}
