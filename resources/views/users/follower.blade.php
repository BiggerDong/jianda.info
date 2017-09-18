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
                    <li role="presentation" ><a href="/users/{{ $user->id }}/followt">关注的话题({{ $user->follow_topics_count }})</a></li>
                    <li role="presentation"><a href="/users/{{ $user->id }}/following">关注的人({{ $user->followings_count }})</a></li>
                    <li role="presentation" class="active"><a href="/users/{{ $user->id }}/follower">关注者({{ $user->followers_count }})</a></li>
                </ul>
                <div class="questions-user-home" style="margin-top: 50px;">
                    @foreach($info[0]->followersi as $follower)
                        <img src="{{ $follower->avatar }}" style="width: 40px;border-radius: 50%;margin-right: 10px;">
                        <a href="/users/{{ $follower->id }}/home" style="text-decoration: none;color: #666;">{{ $follower->name }}</a>
                        <span class="pull-right" style="color: #959FAF;font-size: 12px;">
                            {{$follower->created_at->diffForHumans()}}
                        </span>
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
</style>