<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>404 - 简答</title>

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
    <div class="container">
        <div class="row" style="margin-top: 20rem;">
            <div class="col-md-12">
                <div class="404-div" style="text-align: center;">
                    <img src="http://ot4aplrlt.bkt.clouddn.com/404.png" width="260px">
                    <p style="margin-top: 30px;">人生难免不迷茫 - HTTP404</p>
                    <a class="btn btn-primary btn-sm" href="JavaScript:window.history.go(-1)" style="border: none;">返回上页</a>
                    <a class="btn btn-primary" href="/" style="border: none;background: none;color: #20A0FF;">前往首页</a>
                </div>
            </div>
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 3%;text-align: center;">
                            <footer>
                                <p style="color: #636b6f;">&copy; 2017 简答
                                </p>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>