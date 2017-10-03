<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>关于我们 - 简答</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        Laravel.apiToken = "{{ Auth::check() ? 'Bearer '.Auth::user()->api_token : 'Bearer ' }}";
    </script>
</head>

<body>
    <div id="app">
        <div class="container-fluid">
            <div class="col-md-6 ">
                <a href="/"><img class="login_logo" width="57px" src="http://io.jianda.info/logo_64.png" alt=""></a>
                <h2 style="color: #272B2D">简答 <small style="color: #272B2D"> 关于我们</small></h2>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Jumbotron -->
                    <div class="jumbotron">
                        <h2>简答 - 让答案更简单</h2>
                        <p class="lead">简答是一个轻量级的在线问答社区。在回答中有150字的字数限制，我们认为一般150字以内的答案基本可以解决大多数问题，如果需要额外说明，可以使用富文本编辑器进行补充；查看答案时点击展开了解即可查看。</p>
                        <p><a class="btn btn-md btn-success" href="/login" role="button">简单开始</a></p>
                    </div>

                    <!-- Example row of columns -->
                    <div class="row">
                        <div class="col-lg-6">
                            <h2>免责声明</h2>
                            <p>简答上面的内容（除简答官方账号发布）均由用户所创作，请尊重作者及简答的版权。如在简答发现转载但未标明来源的侵权内容，请作者及时联系我们，我们将在第一时间内进行整改。联系邮箱：service@jianda.info</p>
                        </div>
                        <div class="col-lg-6">
                            <h2>技术支持</h2>
                            <p>
                                <li>Laravel、Vue提供框架开发支持</li>
                                <li>Algolia提供搜索支持</li>
                                <li>Redis提供数据缓存支持</li>
                                <li>七牛云提供云存储支持</li>
                                <li>Webpack提供前端资源构建打包支持</li>
                            </p>
                        </div>
                    </div>
                    <div class="footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 3%;text-align: center;">
                                    <footer>
                                        <img src="http://io.jianda.info/jianda-logo-64-gray.png" alt="" style="width: 20px;margin-bottom: 10px;">
                                        <p style="color: #636b6f;">&copy; 2017 简答 &middot; <i class="iconfont" style="color: rgb(99, 107, 111);font-size: 20px;">&#xe60b;</i> 大头东
                                        </p>
                                    </footer>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</html>