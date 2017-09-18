@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 10px;">
    <div class="row">
        <div class="col-md-8">
            @if($judge == 0)
                <div class="alert alert-dismissible" role="alert" style="background-color: #f3f5f7;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>你的邮箱没有激活！</strong> 为了确保你的账号安全，请激活你的邮箱，激活后可以正常使用。
                    <br>
                    <a class="btn btn-primary btn-sm" id="js_login_mail" style="border: none;margin-top: 20px;">前往激活</a>
                    @if(Auth::check())
                    <input type="hidden" id="email" value="{{ Auth::user()->email }}">
                    @endif
                </div>
            @endif
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
                                @if($question->user->verify !== null)
                                    <span style="display: inline-block;margin-left: 2px;cursor: default;">
                                        <i class="iconfont" style="font-size: 14px;color: #FFA000">&#xe627;</i>
                                    </span>
                                @endif
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
                    <img class="answer-img-h" data-href="/questions/{{ $question->qid }}" src="">
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
            <div class="page">
                {{ $questions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(function () {
            $('.answer-add-h').each(function () {
               var imgsrc = $(this).find("img:first").attr('src');
               $(this).next().attr('src',imgsrc);
            });

            $('.answer-img-h').click(function () {
                var href = $(this).attr('data-href');
                window.location.href = href;
            });

            $('.pagination').find('li:first').children().text('上一页');
            $('.pagination').find('li:last').children().text('下一页');

            @if($judge == 0)
            var hash = {
                'qq.com': 'http://mail.qq.com',
                'gmail.com': 'http://mail.google.com',
                'sina.com': 'http://mail.sina.com.cn',
                '163.com': 'http://mail.163.com',
                '126.com': 'http://mail.126.com',
                'yeah.net': 'http://www.yeah.net/',
                'sohu.com': 'http://mail.sohu.com/',
                'tom.com': 'http://mail.tom.com/',
                'sogou.com': 'http://mail.sogou.com/',
                '139.com': 'http://mail.10086.cn/',
                'hotmail.com': 'http://www.hotmail.com',
                'live.com': 'http://login.live.com/',
                'live.cn': 'http://login.live.cn/',
                'live.com.cn': 'http://login.live.com.cn',
                '189.com': 'http://webmail16.189.cn/webmail/',
                'yahoo.com.cn': 'http://mail.cn.yahoo.com/',
                'yahoo.cn': 'http://mail.cn.yahoo.com/',
                'eyou.com': 'http://www.eyou.com/',
                '21cn.com': 'http://mail.21cn.com/',
                '188.com': 'http://www.188.com/',
                'foxmail.com': 'http://www.foxmail.com',
                'outlook.com': 'http://www.outlook.com'
            }

            var _mail = $("#email").val().split('@')[1];
            for (var j in hash){
                if(j == _mail){
                    $("#js_login_mail").show().attr("href", hash[_mail]);
                }
            }
            @endif

        });
    </script>
@endsection

<style>
    .container {
        color: #000000;
    }

    @media screen and (max-width:980px){
        #feed-time-h {
          display: none;
        }

    }
    
    #nav-option li:nth-child(1) a:nth-child(1) {
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
