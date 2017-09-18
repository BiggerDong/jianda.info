<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
        <title>({{ Auth::user()->unreadNotifications->count() }}){{ config('app.name') }} - 让答案更简单</title>
    @else
        <title>{{ config('app.name') }} - 让答案更简单</title>
@endif

<!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        Laravel.apiToken = "{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}";

            @if(Auth::check()) {
            window.Jianda = {
                name: "{{Auth::user()->name}}",
            }
        }
        @endif
    </script>
</head>
<body>
<div id="app" style="padding-top: 80px;">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo_nav" height="40px" src="http://io.jianda.info/logo_64.png"
                         alt="简答">
                </a>
                @if(Auth::guest())
                <form class="navbar-form" id="search-form-mobile" action="/search">
                    <input type="text" class="form-control" id="search-input-mobile" name="keyword" aria-label="..."
                           placeholder="搜索你感兴趣的问题" style="width: 220px;box-shadow: none;margin-top: -11px;margin-bottom: -20px;">
                    <button type="submit" class="btn btn-link" id="ask-mobile"
                            style="text-decoration: none;margin-top: -16px;margin-bottom: -20px;margin-left: 180px;">
                        <i class="iconfont" id="search-icon-mobile"
                           style="color: #959FAF;font-size: 14px;">&#xe69f;</i>
                    </button>
                </form>
                @endif
            </div>

            <div id="navbar">

                <ul class="nav navbar-nav" id="nav-option">
                    <li><a href="/">简答</a></li>
                    <li><a href="/topics">话题</a></li>
                    <li><a style="cursor: help" title="实时功能暂未上线">实时</a></li>
                </ul>

                <form class="navbar-form navbar-left" id="search-form" action="/search">
                    <input type="text" class="form-control" id="search-input" name="keyword" aria-label="..."
                           placeholder="搜索你感兴趣的问题" style="width: 417px;box-shadow: none;">
                    <button type="submit" class="btn btn-link" id="ask" style="text-decoration: none">
                        <i class="iconfont" id="search_icon"
                           style="color: #959FAF;font-size: 14px;margin-left: -75px;">&#xe69f;</i>
                    </button>
                </form>
                <a href="/questions/create" id="ask-btn" class="btn btn-success"
                   style="margin-top: 10px;margin-left: -12px;">提问</a>

                @if (Auth::guest())
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('login') }}">登录</a></li>
                        <li><a href="{{ route('register') }}">注册</a></li>
                    </ul>
                @else
                    <ul class="nav navbar-nav navbar-right" id="ul_nav">
                        <li>
                            <a href="/notifications" class="notify_nav">
                                <el-badge is-dot class="item" {{ Auth::user()->unreadNotifications->count() > 0 ? "" : ":hidden=true"}}>
                                    <i class="iconfont" style="color: #959FAF;font-size: 22px;">&#xe7c0;</i>
                                </el-badge>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" style="background: none;"
                               data-toggle="dropdown" role="button" aria-expanded="false" >
                                <img class="avatar_nav" width="40px" src="{{ Auth::user()->avatar }}">
                            </a>

                            <ul class="dropdown-menu" role="menu" id="nav_menu" style="padding: 10px 5px 10px 5px;">
                                <li>
                                    <a href="/users/{{ Auth::user()->id }}/home">
                                        <i class="iconfont" style="color: #959FAF;font-size: 16px;">&#xe61b;</i>
                                        <span style="margin-left: 6px;">我的主页</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/password/reset">
                                        <i class="iconfont" style="color: #959FAF;font-size: 16px;">&#xe6a1;</i>
                                        <span style="margin-left: 6px;">账号设置</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="iconfont" style="color: #959FAF;font-size: 14px;">&#xe60c;</i>
                                        <span style="margin-left: 6px;">注销</span>
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>

                        </li>
                    </ul>
                @endif

            </div>


        </div>
    </nav>

    <div class="navbar-fixed-bottom"
         style="margin-bottom: 20px;margin-left: 95%;display: none;background: none;border: none;cursor: pointer;" id="back-to-top"
         data-toggle="tooltip" data-placement="left" title="返回顶部">
        <i class="iconfont" style="color: #959FAF;font-size: 36px;">&#xe617;</i>
    </div>

    @yield('content')


    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-8" style="margin-top: 5%;text-align: center;">
                    <footer>
                        <p style="color: #636b6f;">&copy; 2017 简答
                        </p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media screen and (max-width:980px){
        #navbar {
            display: none;
        }
        #back-to-top {
            opacity: 0;
        }

        .navbar-brand {
            text-align: center;
        }
    }

    @media screen and (min-width:980px){
        #search-form-mobile {
            display: none;
        }
    }
</style>


<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(function () {
        $("#search-input").focus(function () {
            $("#search_icon").css("color","#272B2D");
            $("#nav-option li a").css('z-index','-1');
            startAnimation();
            function startAnimation() {
                $('#search-input').animate({marginLeft: "-=175px",width:"+=265px"}, 300)
                $('#ask-btn').hide()
            }
        }).blur(function () {
            $("#search_icon").css("color","#959FAF");
            startAnimation();
            function startAnimation() {
                $('#search-input').animate({width: "-=265px",marginLeft: "+=175px"}, 300,function () {
                    $('#ask-btn').show()
                    $("#nav-option li a").css('z-index','0');
                })
            }
        });

        $("#search-input-mobile").focus(function () {
            $("#search-icon-mobile").css("color","#272B2D");
            startAnimation();
            function startAnimation() {
                $('#search-input-mobile').animate({marginLeft: "-=68px",width:"+=68px"}, 200)
                $('#search-icon-mobile').animate({marginLeft: "+=68px"}, 200)
            }
        }).blur(function () {
            $("#search-icon-mobile").css("color","#959FAF");
            startAnimation();
            function startAnimation() {
                $('#search-input-mobile').animate({width: "-=68px",marginLeft: "+=68px"}, 200)
                $('#search-icon-mobile').animate({marginLeft: "-=68px"}, 200)
            }
        });

        $(window).scroll(function() {
            $('#back-to-top').tooltip('hide');
            if ($(window).scrollTop() > 1000) {
                $("#back-to-top").fadeIn(100);
            } else {
                $("#back-to-top").fadeOut(100);
            }
        });

        //当点击跳转链接后，回到页面顶部位置
        $("#back-to-top").click(function() {
            $('body,html').animate({
                    scrollTop: 0
                },
                600);
            return false;
        });

        $('#back-to-top').tooltip();
    })
</script>
@yield('js')
</body>
</html>
