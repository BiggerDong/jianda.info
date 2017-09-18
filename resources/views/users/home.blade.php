@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 10px;">
    <div class="row">
        <div class="col-md-2">
            <img class="img-thumbnail" src="{{ $user->avatar }}" style="width: 160px;">
        </div>
        <div class="col-md-6" style="margin-bottom: 20px;margin-top: -10px;">
            <h3 style="color: #000000;margin-bottom: 15px;display: inline-block;">{{ $user->name }}</h3>
            @if($user->verify !== null)
            <p style="display: inline-block;margin-left: 10px;">
                <i class="iconfont" style="font-size: 14px;color: #FFA000">&#xe627;</i>
                <span>{{ $user->verify }}</span>
            </p>
            @endif
            <p style="color: #959FAF">
                <i class="iconfont" style="font-size: 16px;">&#xe60a;</i>
                @if($user->settings['city'] !== null)
                    <span>{{ $user->settings['city'] }}</span>
                @else
                    <span>填写居住地</span>
                @endif
            </p>
            <p style="color: #959FAF">
                <i class="iconfont" style="font-size: 16px;">&#xe63a;</i>
                @if($user->settings['school'] !== null)
                    <span>{{ $user->settings['school'] }}</span>
                @else
                    <span>填写毕业学校</span>
                @endif
            </p>
            <p style="color: #959FAF">
                <i class="iconfont" style="font-size: 16px;">&#xe611;</i>
                @if($user->settings['company'] !== null)
                    <span>{{ $user->settings['company'] }}</span>
                @else
                    <span>填写所在公司</span>
                @endif
            </p>
        </div>
        <div class="col-md-5">
            @if($me->id == $user->id)
            <a class="btn btn-success" style="width: 160px;border: none;margin-bottom: 50px;" href="/users/profile">编辑资料</a>
            @else
            <user-follow-button user="{{ $user->id }}" style="margin-bottom: 30px;margin-left: 30px;"></user-follow-button>
            @endif
        </div>
        <div class="col-md-8" style="">
            <ul class="nav nav-tabs nav-justified">
                <li role="presentation" class="active"><a href="/users/{{ $user->id }}/home">提问({{ $user->questions_count }})</a></li>
                <li role="presentation"><a href="/users/{{ $user->id }}/answers">回答({{ $user->answers_count }})</a></li>
                <li role="presentation"><a href="/users/{{ $user->id }}/followq">关注的问题({{ $user->follow_questions_count }})</a></li>
                <li role="presentation"><a href="/users/{{ $user->id }}/followt">关注的话题({{ $user->follow_topics_count }})</a></li>
                <li role="presentation"><a href="/users/{{ $user->id }}/following">关注的人({{ $user->followings_count }})</a></li>
                <li role="presentation"><a href="/users/{{ $user->id }}/follower">关注者({{ $user->followers_count }})</a></li>
            </ul>
            <div class="questions-user-home" style="margin-top: 50px;">
                @foreach($user->questions->sortByDesc('created_at') as $question)
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="/users/{{ $question->user->id }}/home" >
                                        <img class="head-img-h" src="{{ $question->user->avatar }}">
                                    </a>
                                </div>
                                <div class="col-md-10">
                                    <a id="user-name-h" href="/users/{{ $question->user->id }}/home">
                                        {{ $question->user->name }}
                                    </a>
                                    @foreach($question->topics->take(1) as $topic)
                                        <p class="from-topic-h" >
                                            @if($question->topics()->count('topic_id') > 1)
                                                来自 {{ $topic->name }} 等{{ $question->topics()->count('topic_id') }}个话题
                                            @else
                                                来自 {{ $topic->name }} 话题
                                            @endif
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                        <span class="pull-right" id="feed-time-h">
                            {{$question->created_at->diffForHumans()}}
                        </span>
                        </div>
                    </div>
                    <div class="question-title-index-h">
                        <a href="/questions/{{ $question->qid }}" id="question-id-h">
                            <h4 class="question-title-h">{{ $question->title }}</h4>
                        </a>
                        <p>
                            @foreach($question->answers->sortByDesc('votes_count')->take(1) as $answer)
                                @if(count($answer) > 0)
                                    {{ $answer->body }}
                                @endif
                            @endforeach
                        </p>
                    </div>
                    <div class="question-index-h">
                        <a id="question-looked-h" title="浏览{{ $question->pv }}次">
                            <i class="iconfont icon-looked-h">&#xe764;</i>
                            <span class="question-looked-word-h">{{ $question->pv }}</span>
                        </a>
                        <a id="question-answered-h" title="回答{{ $question->answers_count }}个">
                            <i class="iconfont icon-answered-h">&#xe608;</i>
                            <span class="question-answered-word-h">{{ $question->answers_count }}</span>
                        </a>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .nav.nav-tabs.nav-justified li a {
        color: #000000;
    }
    .head-img-h {
        border-radius: 50%;
        width: 40px;
    }
    #user-name-h {
        color: #000000;
        text-decoration: none;
    }

    .from-topic-h {
        color: #959FAF;
        font-size: 12px;
    }

    #feed-time-h {
        color: #959FAF;
        margin-top: 7px;
        font-size: 12px;
    }

    #question-id-h {
        color: #000000;
        text-decoration: none;
    }

    .question-title-h {
        font-weight: 600;
    }

    .question-index-h {
        margin-bottom: -10px;
        margin-top: -3px;
    }

    #question-looked-h {
        color: #959FAF;
        margin-right: 10px;
        text-decoration: none;
        cursor: default;
    }

    .iconfont.icon-looked-h {
        font-size: 15px;
    }


    .question-looked-word-h {
        font-size: 12px;
    }

    #question-answered-h {
        color: #959FAF;
        text-decoration: none;
        cursor: default;
    }

    .iconfont.icon-answered-h {
        font-size: 15px;
    }

    .question-answered-word-h {
        font-size: 12px;
    }
</style>