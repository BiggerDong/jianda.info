<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>注册 - 简答</title>
    <style>
        * {
            background-color: #FFFFFF;
        }

        body {
            background-color: #FFFFFF;
        }

    </style>
</head>
<body>
    <div id="app"></div>

    <div class="container-fluid">
        <div class="col-md-6 ">
            <a href="/"><img class="login_logo" width="57px" src="http://io.jianda.info/logo_64.png" alt=""></a>
            <h2 style="color: #272B2D">简答 <small id="login-logo-to-change" style="color: #272B2D">让答案更简单</small></h2>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="login_text">
                    <p class="lead genaral_text">已有</p><p class="number_text">{{ $message->count() }}</p><p class="lead genaral_text">个人加入简答，</p>
                    <br>
                    <p class="lead genaral_text">已有</p><p class="number_text">{{ $question->count() }}</p><p class="lead genaral_text">个问题被问起，</p>
                    <br>
                    <p class="lead genaral_text">已有</p><p class="number_text">{{ $question->sum('answers_count') }}</p><p class="lead genaral_text">个答案被回答，</p>
                    <br>
                    <p class="lead genaral_text">还有更多问题和答案，在等你来。</p>
                </div>
            </div>

            <div class="login-to-show" style="text-align: center;margin-top: 150px;">
                <a class="btn btn-success" href="JavaScript:window.history.go(-1)">请前往PC端注册或返回上页</a>
            </div>

            <div class="col-md-4 col-md-offset-1 register_model" id="login-to-hide">
                <h2>注册</h2>
                <div class="login_show">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-2 col-md-offset-1 control-label">名字&nbsp;</label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                       placeholder="请输入你的姓名或昵称" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-2 col-md-offset-1 control-label">邮箱&nbsp;</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                                       placeholder="请输入你的邮箱作为账号" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-2 col-md-offset-1 control-label">密码&nbsp;</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password"
                                        placeholder="密码长度不小于6位" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-2 col-md-offset-1 control-label">确认&nbsp;</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                                       placeholder="请再次确认你的密码" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                            <label for="captcha" class="col-md-3 col-md-offset-0 control-label">验证码</label>
                            <div class="col-md-4">
                                <input  type="text" class="form-control" name="captcha"
                                        placeholder="4位验证码" required>
                                @if ($errors->has('captcha'))
                                    <span class="help-block">
                                          <strong>{{ $errors->first('captcha') }}</strong>
                                      </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <img src="{{captcha_src()}}" alt="验证码" title="点击换一张" id="captcha" data-captcha-config="default">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <button type="submit" class="btn btn-success form-control" >
                                    注册
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-11 col-md-offset-1" style="margin-top: 7px;">
                                <lable class="login_auth_logo">社交账号登录
                                    &nbsp;&nbsp;
                                    <a href="/auth/weibo" style="text-decoration: none;" title="微博">
                                        <i class="iconfont" style="color: #959FAF;font-size: 19px;">&#xe615;</i>
                                    </a>
                                    &nbsp;&nbsp;
                                    <a href="/auth/qq" style="text-decoration: none;" title="QQ">
                                        <i class="iconfont" style="color: #959FAF;font-size: 20px;">&#xe60e;</i>
                                    </a>
                                    &nbsp;&nbsp;
                                    <a href="/auth/github" style="text-decoration: none;" title="GitHUb">
                                        <i class="iconfont" style="color: #959FAF;font-size: 22px;">&#xe621;</i>
                                    </a>

                                    <a href="/login" style="text-decoration: none;margin-left: 60px;color: #272B2D">
                                        登录
                                    </a>

                                </lable>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 15%" id="footer-to-hide">
                <hr class="hr_footer">
                <footer>
                    <p class="pull-right" >
                        <a target="_blank" href="http://www.miitbeian.gov.cn"
                           style="color: #636b6f;text-decoration: none;">辽ICP备17009065号-1</a>
                    </p>

                    <p>&copy; 2017 简答 &middot;
                        <a href="/about" style="color: #636b6f;text-decoration: none;"
                        >关于我们</a> &middot;
                        <a  style="color: #636b6f;text-decoration: none;">简答爱你</a> &middot;
                        <a >
                            <img height="21px" style="margin-top: -4px;" src="http://io.jianda.info/alixin.png" alt="">
                        </a>
                    </p>

                </footer>
            </div>
        </div>
    </div>

<style>
    @media screen and (max-width:980px){
        .login_text {
            display: none;
        }

        #login-to-hide {
            display: none;
        }

        #footer-to-hide {
            display: none;
        }

        #login-logo-to-change {
            display: none;
        }
    }

    @media screen and (min-width:980px){
        .login-to-show {
            display: none;
        }
    }

    ::-webkit-scrollbar {
        display: none;
    }
</style>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/captcha.js') }}"></script>
</body>
</html>

