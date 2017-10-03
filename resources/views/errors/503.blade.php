<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>503 - 简答</title>

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
                    <i class="iconfont" style="color: #959FAF;font-size: 130px;">&#xe67e;</i>
                    <p style="margin-top: 30px;">马上回来，简单继续 - HTTP503</p>
                </div>
            </div>
            <div class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 3%;text-align: center;">
                            <footer>
                                <img src="http://io.jianda.info/jianda-logo-64-gray.png" alt="" style="width: 20px;margin-bottom: 10px;">
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