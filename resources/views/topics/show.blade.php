@extends('layouts.app')
<head>
    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
        <title>({{ Auth::user()->unreadNotifications->count() }}){{ $topic->name }}话题 - 简答</title>
    @else
        <title>{{ $topic->name }}话题 - 简答</title>
    @endif
</head>
@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-8" id="topic-to-hide">
                <div class="topic">
                    <div class="row">
                        <div class="col-xs-2 col-md-2">
                            <img src="{{ $topic->cover }}"
                                 style="width:130px;border-bottom-left-radius: 5px;border-top-left-radius: 5px;" alt="">
                        </div>
                        <div class="col-xs-8 col-md-10">
                            <div class="topic-info-s"
                                 style="height: 130px;border: 1px solid #e1e8ed;
                                 border-bottom-right-radius: 5px;border-top-right-radius: 5px;color: #8899a6">
                                <div class="row">
                                    <h3 class="col-md-6" style="margin-left: 14px;margin-top: 10px;color: #000000;">{{ $topic->name }}</h3>
                                </div>
                                <p class="col-md-10" style="margin-top: -1px;">{{ $topic->describe }}</p>
                                <p class="col-md-3" style="margin-top: -3px;">
                                    <span style="">热度排行 {{ $top[0] + 1 }}</span>
                                </p>
                                <p class="col-md-3 col-md-pull-1" style="margin-top: -3px;">关注人数 {{ $topic->followers_count }}</p>
                                <topic-follow-button topic="{{ $topic->id }}"></topic-follow-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8" id="topic-to-show">
                <div class="row">
                    <h3 class="col-md-6" style="margin-left: 14px;margin-top: -15px;">{{ $topic->name }}</h3>
                </div>
                <p class="col-md-10" style="color: #8899a6;">{{ $topic->describe }}</p>
                <p class="col-md-3" style="color: #8899a6;">
                    <span style="">热度排行 {{ $top[0] + 1 }}</span>
                </p>
                <p class="col-md-3 pull-right" style="color: #8899a6;margin-top: -34px;">关注人数 {{ $topic->followers_count }}</p>
            </div>
            <div class="col-md-4">
                    <a class="btn" href="/topics" role="button"
                       style="border: 1px solid #959FAF;background: none;color: #959FAF;margin-left: 130px;margin-top: 45px;">更多话题</a>
            </div>
        </div>
        @if($topic->questions()->count() > 0)
            <div class="row" style="margin-top: 60px;">
                <div class="col-md-8">
                    <p style="color: #8899a6;margin-bottom: -10px;">当前话题下共创建了 {{ $topic->questions->count() }} 个问题</p>
                    <hr >
                    @foreach($questions as $question)
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
                                        <p class="from-topic-h" >
                                            来自 {{ $topic->name }} 话题
                                        </p>
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
                                        <a href="/questions/{{ $question->qid }}" id="question-id-h">
                                            {{ $answer->body }}
                                        </a>
                                    @endif
                                @endforeach
                            </p>
                            <div class="answer-add-h">
                                @foreach($question->answers->sortByDesc('votes_count')->take(1) as $answer)
                                    {!! $answer->add !!}
                                @endforeach
                            </div>
                            <img class="answer-img-h"  src="">
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
                            <question-follow-button-s question="{{ $question->id }}"></question-follow-button-s>
                        </div>
                        <hr>
                    @endforeach
                    <div class="page" style="text-align: center;">
                        {{ $questions->links() }}
                    </div>
                </div>
                @if($question->topics->where('name','!==',$topic->name)->count() >= 1)
                    <div class="col-md-3" id="related-to-show">
                        <p class="hot-topic-s-p"
                           style="font-size: 14px;border: 1px solid #959FAF;
                                  text-align: center;color: #959FAF;padding: 4px;border-radius: 3px;">
                            <span>与{{ $topic->name }}相关</span>
                        </p>
                        <div class="hot-topic" style="margin-top: 18px">
                            @foreach($relation as $relate)
                                <a href="/topics/{{ $topicFor->where('name',$relate)->first()->tid }}" style="color: #8899a6;">
                                    <p>{{ $relate }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection

<style>
    @media screen and (max-width:980px){
        #topic-to-hide {
             display: none;
         }

        #feed-time-h {
            display: none;
        }
    }

    @media screen and (min-width:980px){
        .related-to-show {
            margin-left: 45px;
        }

        #topic-to-show {
            display: none;
        }

        #related-to-show {
            margin-left: 45px;
        }
    }

    #topic-follow-s {
        margin-top: -3px;
        color: #8899a6;
        cursor: pointer;
        text-decoration: none;
    }

    .container {
        color: #000000;
    }

    .page {
        text-align: center;
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

    .answer-add-h {
        display: none;
    }

    .answer-img-h {
        max-width: 200px;
        max-height: 120px;
        margin-bottom: 15px;
        border-radius: 3px;
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

@section('js')
    <script>
        $(function () {
            $('#topic-follow-s').mouseover(function () {
                $(this).css('color','#000000')
            }).mouseout(function () {
                $(this).css('color','#8899a6')
            });

            $('.answer-add-h').each(function () {
                var imgsrc = $(this).find("img:first").attr('src');
                $(this).next().attr('src',imgsrc);
            });

            $('.pagination').find('li:first').children().text('上一页');
            $('.pagination').find('li:last').children().text('下一页');
        });
    </script>
@endsection