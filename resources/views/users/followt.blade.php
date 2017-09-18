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
                    <li role="presentation"><a href="/users/{{ $user->id }}/home">提问({{ $user->questions_count }})</a></li>
                    <li role="presentation"><a href="/users/{{ $user->id }}/answers">回答({{ $user->answers_count }})</a></li>
                    <li role="presentation"><a href="/users/{{ $user->id }}/followq">关注的问题({{ $user->follow_questions_count }})</a></li>
                    <li role="presentation" class="active"><a href="/users/{{ $user->id }}/followt">关注的话题({{ $user->follow_topics_count }})</a></li>
                    <li role="presentation"><a href="/users/{{ $user->id }}/following">关注的人({{ $user->followings_count }})</a></li>
                    <li role="presentation"><a href="/users/{{ $user->id }}/follower">关注者({{ $user->followers_count }})</a></li>
                </ul>
                <div class="questions-user-home" style="margin-top: 50px;">
                    <div class="topics">
                        @foreach($info[0]->followst->sortByDesc('created_at') as $topic)
                            <div class="topic" style="margin-top: 35px;" data-href="/topics/{{ $topic->tid }}">
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
                                                <span style="">创建问题 {{ $topic->questions_count }}</span>
                                            </p>
                                            <p class="col-md-3 col-md-pull-1" style="margin-top: -3px;">关注人数 {{ $topic->followers_count }}</p>
                                            <topic-follow-button class="followbtn" topic="{{ $topic->id }}"></topic-follow-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach()
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .nav.nav-tabs.nav-justified li a {
        color: #000000;
    }

    .followbtn:hover {
        text-decoration: none;
    }
</style>

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

        });
    </script>
@endsection