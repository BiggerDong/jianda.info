@extends('layouts.app')
<head>
    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
        <title>({{ Auth::user()->unreadNotifications->count() }})话题 - 简答</title>
    @else
        <title>话题 - 简答</title>
    @endif
</head>
@section('content')
<div class="container" style="margin-top: 10px;">
    <div class="row">
        <div class="col-md-8">
            <div class=" pull-right">
                <a class="btn btn-primary btn-sm" style="border: none;" id="create-topic-to-hide"
                   data-toggle="collapse" data-target="#collapse">创建话题</a>
            </div>
            <p style="margin-bottom: -10px;">
                <span><i class="iconfont" style="font-size: 18px;">&#xe610;</i></span> 已收录 {{ $count }} 个话题
            </p>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="collapse" id="collapse">
                        <div class="well" style="background-color: #f3f5f7;border: none;box-shadow: none;height: 75px;">
                            <div class="col-lg-6" style="margin-left: 95px;">
                                <form action="/newtopics" method="post">
                                    {{ csrf_field() }}
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="name" placeholder="输入你想要创建的话题"
                                               style="box-shadow: none;" required>
                                        <span class="input-group-btn">
                                        <button class="btn btn-success" type="submit">提交话题</button>
                                    </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4" style="margin-top: 7px;margin-left: -10px;">
                                <i class="iconfont" id="icon-topic-info" style="font-size: 16px;cursor: pointer;color: #959FAF"
                                   data-toggle="tooltip" data-placement="right" title="已收录的话题不能创建，提交话题审核通过后，才会被收录。">&#xe63f;
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="topics">
                @foreach($topics as $topic)
                    <div class="topic" style="margin-top: 35px;" data-href="/topics/{{ $topic->tid }}">
                        <div class="row" id="topics-to-hide">
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
                                        <span style="">创建问题 {{ $topic->questions_count }}</span>
                                    </p>
                                    <p class="col-md-3 col-md-pull-1" style="margin-top: -3px;">关注人数 {{ $topic->followers_count }}</p>
                                    <topic-follow-button class="followbtn" topic="{{ $topic->id }}"></topic-follow-button>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="topics-to-show">
                            <div class="row">
                                <h3 class="col-md-6" style="margin-left: 14px;margin-top: -15px;color: #333">{{ $topic->name }}</h3>
                            </div>
                            <p class="col-md-10" style="color: #8899a6;">{{ $topic->describe }}</p>
                            <p class="col-md-3" style="margin-top: -3px;">
                                <span style="color: #8899a6;">创建问题 {{ $topic->questions_count }}</span>
                            </p>
                            <p class="col-md-3 pull-right" style="color: #8899a6;margin-top: -34px;">关注人数 {{ $topic->followers_count }}</p>
                        </div>
                    </div>
                @endforeach()
            </div>
            <div class="page" style="text-align: center">
                {{ $topics->links() }}
            </div>
        </div>
        <div class="col-md-3"id="hot-topics-to-show">
            <p class="hot-topic-s-p"
               style="font-size: 14px;border: 1px solid #959FAF;
                              text-align: center;color: #959FAF;padding: 4px;border-radius: 3px;">
                <span>热门话题</span>
            </p>
            <div class="hot-topic" style="margin-top: 18px">
                @foreach($hots as $hot)
                    <a href="/topics/{{ $hot->tid }}" style="color: #8899a6;">
                        <p>{{ $hot->name }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $(function () {
            $('#topic-follow-s span').mouseover(function () {
                $(this).css('color','#000000')
            }).mouseout(function () {
                $(this).css('color','#8899a6')
            });

            $('.topic').mouseover(function () {
                $(this).css('cursor','pointer')
            }).mouseout(function () {
                $(this).css('cursor','default')
            });

            $('.topic').click(function () {
                var href = $(this).attr('data-href');
                window.location.href = href;
            });

            $('.followbtn').click(function () {
                return false;
            });

            $('#icon-topic-info').tooltip();

            $('.pagination').find('li:first').children().text('上一页');
            $('.pagination').find('li:last').children().text('下一页');
        });
    </script>
@endsection


<style>

    @media screen and (max-width:980px){
        #create-topic-to-hide {
            display: none;
        }

        #topics-to-hide {
            display: none;
        }

        #hot-topics-to-show {
            margin-top: 20px;
        }
    }

    @media screen and (min-width:980px){
        #hot-topics-to-show {
            margin-left: 45px;
            margin-top: 100px;
        }

        #topics-to-show {
            display: none;
        }
    }

    #topic-follow-s {
        text-decoration: none;
        cursor: pointer;
        margin-top: -3px;
    }

    #nav-option li:nth-child(2) a:nth-child(1) {
        color: #000000;
    }
</style>