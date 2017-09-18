@extends('layouts.app')
<head>
    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
        <title>({{ Auth::user()->unreadNotifications->count() }})修改问题 - 简答</title>
    @else
        <title>修改问题 - 简答</title>
    @endif
</head>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8" style="padding-top: 18px;">
                <div class="row" style="margin-bottom: 20px;color: #000000;">
                    <div class="col-md-1 col-md-offset-1">
                        <i class="iconfont" style="font-size: 30px;">&#xe600;</i>
                    </div>
                    <div class="col-md-2" style="margin-left: -25px;">
                        <h3 style="margin-top: 7px;">提问</h3>
                    </div>
                </div>

                <form action="/questions/{{ $question->qid }}" method="post" class="form-horizontal" style="color: #000000;">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                        <div class="col-md-1">
                            <img src="{{ Auth::user()->avatar }}" alt="" style="width: 40px;border-radius: 50%;">
                        </div>
                        <div class="col-md-11">
                            <input type="text" name="title" id="qtitle" class="form-control"
                                   placeholder="标题：写下你的问题" value="{{ $question->title }}"
                                   style="height: 50px;box-shadow: none;font-size: 16px;" required>
                        </div>
                        @if ($errors->has('title'))
                            <span class="help-block pull-right" style="margin-right: 15px;">
                                  <strong>{{ $errors->first('title') }}</strong>
                              </span>
                        @endif
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <div class="col-md-6">
                                @foreach($question->topics as $topic)
                                    <a class="qtopicshow pull-right" href="/topics/{{$topic->tid}}"
                                       style="color: #FFFFFF;background-color: #CDC9C9;
                                    color: rgb(255, 255, 255);
                                    border-radius: 3px;
                                    padding: 3px 10px;
                                    margin: 0px 0px 0px 10px;
                                    text-decoration: none">{{$topic->name}}</a>
                                @endforeach
                        </div>
                        <div class="col-md-2" style="margin-top: 2px;margin-left: -10px;">
                            <i class="iconfont" style="font-size: 18px;cursor: pointer;" data-container="body" data-toggle="popover"
                               data-placement="right" data-content="选择相关话题后，暂不支持修改。">&#xe63f;
                            </i>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
                        <div class="col-md-11 col-md-offset-1">
                                <textarea name="body" id="qbody" rows="8" class="form-control"
                                          placeholder="描述：补充问题说明(可选)" style="box-shadow: none;resize: none;">
                                    {{ $question->body }}
                                </textarea>
                        </div>
                        @if ($errors->has('body'))
                            <span class="help-block pull-right" style="margin-right: 15px;">
                                    <strong>{{ $errors->first('body') }}</strong>
                                </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-success pull-right" style="width: 100px;">提交</button>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/select2.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="popover"]').popover();
        });
    </script>
@endsection