@extends('layouts.app')
@section('content')
    <div class="container" style="margin-top: 10px;">
        <div class="row">
            <a class="btn btn-link" href="/users/{{ Auth::user()->id }}/home" style="color: #333;text-decoration: none;">&lt;返回我的主页</a>
            <avatar avatar="{{ Auth::user()->avatar }}"></avatar>
            <div class="col-md-8" style="margin-left: 33px;">
                <form class="form-horizontal" role="form" method="POST" action="/users/profile">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <span  class="col-md-2 control-label">
                            <i class="iconfont" style="font-size: 16px;color: #959FAF;">&#xe6a0;</i>
                        </span>
                        <div class="col-md-7" {{ $errors->has('name') ? ' has-error' : '' }}>
                            <input type="text" class="form-control" name="name"
                                   placeholder="输入名字" value="{{ Auth::user()->name }}" autofocus required>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <span  class="col-md-2 control-label">
                            <i class="iconfont" style="font-size: 16px;color: #959FAF;">&#xe60a;</i>
                        </span>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="city"
                                   placeholder="输入居住地" value="{{ Auth::user()->settings['city'] }}" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <span  class="col-md-2 control-label">
                            <i class="iconfont" style="font-size: 16px;color: #959FAF;">&#xe63a;</i>
                        </span>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="school"
                                   placeholder="输入毕业学校" value="{{ Auth::user()->settings['school'] }}"autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <span  class="col-md-2 control-label">
                            <i class="iconfont" style="font-size: 16px;color: #959FAF;">&#xe611;</i>
                        </span>
                        <div class="col-md-7">
                            <input type="text" class="form-control" name="company"
                                   placeholder="输入所在公司" value="{{ Auth::user()->settings['company'] }}"autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-7 col-md-offset-2">
                            <button type="submit" class="btn btn-success form-control" >
                                确认修改
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .nav.nav-tabs.nav-justified li a {
        color: #000000;
    }

    .form-horizontal input {
        box-shadow: none;
    }
</style>