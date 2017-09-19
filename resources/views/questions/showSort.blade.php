@extends('layouts.app')
@if(Auth::check())
    @include('vendor.ueditor.assets')
@endif
<head>
    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
        <title>({{ Auth::user()->unreadNotifications->count() }}){{ $question->title }} - 简答</title>
    @else
        <title>{{ $question->title }} - 简答</title>
    @endif
    <meta name="description" content="{{ $question->body }}"/>
    <!--  css & js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/js/social-share.min.js"></script>
</head>
@section('content')
    <div class="container" style="color: #000000;margin-top: -10px;">
        <div class="row">
            <div class="col-md-8">
                <div class="qtitleshow">
                    <h3 class="qt" style="font-weight: 600">{{ $question->title }}</h3>
                </div>
                <div class="qbodyshow">
                    <p style="font-size: 16px;">{{ $question->body }}</p>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <div class="qedit" style="margin-top: 5px;">
                                <a class="edits" href="/questions/{{ $question->qid }}/edit" style="color: #959FAF;text-decoration: none;">
                                    <i class="iconfont"
                                       style="font-size: 15px;">&#xe83f;</i> 修改
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-10">
                        <div class="qtopicsshow">
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
                    </div>
                </div>
                <div class="row" id="share-warning-time">
                    <div class="col-md-2" style="margin-right: -50px;">
                        <button class="sharebtn">
                            <i class="iconfont" style="font-size: 13px;">&#xe648;</i>
                            <span>分享</span>
                        </button>
                    </div>
                    <div class="col-md-2" >
                        <warning-button question="{{ $question->id }}"></warning-button>
                    </div>
                    <div class="col-md-8">
                        <div style="color: #959FAF;margin-right: -50px;" class="pull-right">
                            <button class="sinfo">
                                <a href="/users/{{ $question->user->id }}/home" style="color: #959FAF;text-decoration: none;">{{ $question->user->name }}</a>
                                <span> 创建于{{ $question->created_at->diffForHumans() }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="olor: #666;">

                <div class="amswers_count" style="display: inline-block;margin-left:95px;margin-right:50px;margin-top: 10px;">
                <span style="display: inline-block;margin-left: 12px;">
                    <i class="iconfont"style="color: #959FAF;font-size: 22px;">&#xe608;</i>
                </span>
                    <p>{{ $question->answers_count }}个回答</p>
                </div>
                <div class="followers_count" style="display: inline-block">
                <span style="display: inline-block;margin-left: 12px;">
                    <i class="iconfont"style="color: #959FAF;font-size: 20px;">&#xe61d;</i>
                </span>
                    <p>{{ $question->followers_count }}个关注</p>
                </div>
                <div class="follow_q_btn" style="margin-left: 125px;margin-top: 10px;">
                    <question-follow-button question="{{ $question->id }}"></question-follow-button>
                </div>

            </div>
        </div>
        <hr>
        <div id="share" class="social-share" data-initialized="true"
             data-description="" data-wechat-qrcode-title="分享到微信朋友圈"
             data-wechat-qrcode-helper="<p>微信里点击“发现”，扫一下</p><p>二维码即可将网页分享至朋友圈。</p>"
             data-image="http://io.jianda.info/logo_64.png">
            <a class="social-share-icon icon-weibo" title="分享到微博"></a>
            <a class="social-share-icon icon-wechat" title="分享到微信"></a>
            <a class="social-share-icon icon-qq" title="分享到QQ"></a>
            <a class="social-share-icon icon-qzone" title="分享到QQ空间"></a>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="answer_info_bar" style="margin-top: 30px;">
                    <a class="btn btn-sm btn-primary" id="toanswer_btn">我来回答</a>
                    <div class="btn-group btn-group-sm pull-right" role="group" aria-label="...">
                        <button type="button" class="btn btn-default ">
                            <a style="color: #666;text-decoration: none;" href="/questions/{{ $question->qid }}">默认排序</a>
                        </button>
                        <button type="button" class="btn btn-default active">时间排序</button>
                    </div>
                </div>
                <hr>

                @foreach($question->answers->sortByDesc('created_at') as $answer)
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="/users/{{ $answer->user->id }}/home" >
                                        <img src="{{ $answer->user->avatar }}"
                                             width="40px;" style="border-radius: 50%;" alt="">
                                    </a>
                                </div>
                                <div class="col-md-10">
                                    <a style="color: #000000;text-decoration: none;" href="/users/{{ $answer->user->id }}/home">
                                        {{ $answer->user->name }}
                                    </a>
                                    @if($answer->user->verify !== null)
                                        <span style="display: inline-block;margin-left: 2px;cursor: default;">
                                        <i class="iconfont" style="font-size: 14px;color: #FFA000">&#xe627;</i>
                                    </span>
                                    @endif
                                    <p style="color: #959FAF;font-size: 12px;">共参与了{{ $answer->user->answers_count }}次回答</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                        <span class="pull-right" id="timetohide" style="color: #959FAF;margin-top: 9px;font-size: 12px;">
                            {{$answer->created_at->diffForHumans()}}
                        </span>
                        </div>
                    </div>
                    <div class="abodyshow">
                        <p>{{ $answer->body }}</p>
                    </div>
                    <div class="row" id="tomore">
                        <div class="col-md-12">
                            @if(count($answer->add) > 0)
                                <div class="aaddshow">
                                    <a class="btn btn-sm btn-success pull-right goknow" id="goknow">展开了解</a>
                                    <div class="aaddshowself" style="margin-top: 30px;display: none;">
                                        {!! $answer->add !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <vote-comment answer="{{ $answer->id }}" count="{{ $answer->votes_count }}" id="vote-comment"
                                  countc="{{ $answer->comments()->count() }}" style="margin-left: 60px;">
                    </vote-comment>
                    <hr>
                @endforeach
            </div>
            @if($topic->questions->where('qid','!=',$question->qid)->count() >= 1 )
                <div id="guess" class="col-md-3" style="margin-top: 30px;">
                    <p class="guessp"
                       style="font-size: 14px;border: 1px solid #959FAF;border-radius: 3px;
               text-align: center;color: #959FAF;padding: 4px;border-radius: 3px;"><span>你可能感兴趣</span></p>
                    <div class="guess" style="margin-top: 18px">
                        @foreach($question->topics->take(1) as $topic)
                            @foreach($topic->questions->where('qid','!=',$question->qid)->take(5) as $questionFor)
                                <p class="guessqt">
                                    <a style="color: #333;" href="/questions/{{ $questionFor->qid }}">{{ $questionFor->title }}</a>
                                    <span style="color: #666;font-size: 12px;">{{ $questionFor->answers_count }}个回答</span>
                                </p>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-8">
                @if(Auth::check())
                    <h4 style="margin-top: 80px;">添加回答</h4>
                    <hr>
                    <div class="add_answer" id="add_answer">
                        <form action="/questions/{{ $question->id }}/answer" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="header_bar" style="margin-bottom: 10px;">
                                    <div class="add_answer_avatar">
                                        <img src="{{ Auth::user()->avatar }}" alt="" width="40px;" style="border-radius: 50%;">
                                    </div>
                                </div>
                                <textarea class="form-control"
                                          id="answer_area"
                                          style="box-shadow: none;border-top: none;border: none;resize: none"
                                          name="body" id="" placeholder="在这写下你的答案"
                                          cols="30" rows="6"
                                          onKeyDown="textCounter(body,remLen,150);" onKeyUp="textCounter(body,remLen,150);" required>
                        </textarea>
                            </div>
                            <div class="form-group">
                                <!-- 编辑器容器 -->
                                <script id="editor" class="editor" name="add" type="text/plain"></script>
                            </div>
                            <button class="btn btn-success pull-right" style="width: 100px;margin-top: -5px;">回答</button>
                            <div class="numbershow pull-right" style="margin-right: 20px;margin-top: 3px;">
                                <input class="" name="remLen" type="text" value="150" size="2" readonly="readonly"
                                       style="border: none;margin-right: -2px;">
                                <span style="font-size: 14px;">/ 150</span>
                            </div>
                            <div class="add_answer_btn">
                                <button class="btn btn-link" type="button" id="add_answer_btn" style="color: #636b6f;margin-top: -5px;text-decoration: none;">
                                    补充答案(可选)
                                </button>
                                <span style="margin-left: -10px;">
                            <i class="iconfont" style="font-size: 14px;cursor: pointer;color: #636b6f;"
                               data-container="body" data-toggle="popover"
                               data-placement="right" data-content="针对一般性回答只提供150字输入，要额外补充说明时，可以补充答案。">&#xe63f;
                            </i>
                        </span>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

<style>
    body {
        background-color: #ffffff;
    }

    @media screen and (max-width:980px){
        #share-warning-time {
            display: none;
        }

        #vote-comment {
            display: none;
        }

        .abodyshow {
            margin-left: 0px;
        }

        #timetohide {
            display: none;
        }

        .aaddshowself img {
            width: 330px;
        }
    }

    @media screen and (min-width:980px){
        .abodyshow {
            margin-left: 55px;
        }

        #tomore {
            margin-top: 30px;
        }

        #goknow {
            margin-bottom: -20px;
        }

        .aaddshowself {
            margin-left: 55px;
        }

        #guess {
            margin-left: 45px;
        }
    }

    #goknow {
        background: none;
        color: #272B2D;
    }

    #goknow:hover {
        background: #272B2D;
        color: #ffffff;
    }

    .votebtn {
        margin-bottom: -10px;
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        color: #959FAF;
    }

    .votebtn.true {
        margin-bottom: -10px;
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        color: #000000;
    }

    .votebtn:hover {
        color: #000000;
    }


    .combtn {
        margin-bottom: -10px;
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        color: #959FAF;
    }

    .combtn:hover {
        color: #000000;
    }

    .sharebtn {
        margin-bottom: -10px;
        margin-top: 20px;
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        color: #959FAF;
    }

    .sharebtn:hover {
        color: #000000;
    }

    .flagbtn {
        margin-bottom: -10px;
        margin-top: 20px;
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        color: #959FAF;
    }

    .flagbtn:hover {
        color: #000000;
    }

    .sinfo {
        margin-bottom: -10px;
        margin-top: 20px;
        text-decoration: none;
        cursor: pointer;
        background: none;
        border: none;
        color: #959FAF;
    }

    .aaddshowself img {
        max-width: 600px;
        display: block;
        margin: 0 auto;
    }

    #share {
        margin-top: -15px;
        display: none;
    }

    #share a {
        text-decoration: none;
        border: none;
    }

</style>


@section('js')
    @if(Auth::check())
        <script src="{{ asset('js/editor.js') }}"></script>
    @endif
    <script LANGUAGE="JavaScript">
        <!--//
        function textCounter(field, countfield, maxlimit) {
            // 函数，3个参数，表单名字，表单域元素名，限制字符；
            if (field.value.length > maxlimit)
            //如果元素区字符数大于最大字符数，按照最大字符数截断；
                field.value = field.value.substring(0, maxlimit);
            else
            //在记数区文本框内显示剩余的字符数；
                countfield.value = maxlimit - field.value.length;
        }
        //-->
    </script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="popover"]').popover();
            $('#add_answer_btn').click(function () {
                $('.editor').show();
                $('.editor').css({'height':'auto'});
                $('.numbershow.pull-right').hide();
            });
            $('.goknow').click(function () {
                $(this).next('.aaddshowself').show();
                $(this).hide();
            });
            $('#toanswer_btn').click(function () {
                @if(!Auth::check())
                    window.location.href = '/login';
                @else
                    $('body,html').animate({
                        scrollTop : document.body.scrollHeight
                    },
                    600);
                $('#answer_area').focus();
                @endif
            });
            $('.votebtn').tooltip();
            $('.votebtn').click(function () {
                $('.votebtn').tooltip('destroy');
            });
            $('.qtopicshow').mouseover(function () {
                $(this).css('background','#B7B7B7')
            }).mouseout(function () {
                $(this).css('background','#CDC9C9')
            });

            $('.edits').mouseover(function () {
                $(this).css('color','#000000')
            }).mouseout(function () {
                $(this).css('color','#959FAF')
            });
            $('.combtn').click(function () {
                $(this).parent().parent().next().find('.collapse').collapse('toggle');
            });

            $('.sharebtn').click(function () {
                $('#share').slideToggle();
            });

            $('.sinfo a').mouseover(function () {
                $(this).css('color','#000000')
            }).mouseout(function () {
                $(this).css('color','#959FAF')
            });

            $('.aaddshowself').find('img').attr('title','');

        });

    </script>

    @if(Auth::check())
        <!-- 实例化编辑器 -->
        <script type="text/javascript">
            var ue = UE.getEditor('editor');
            ue.ready(function() {
                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
            });
        </script>
    @endif
@endsection