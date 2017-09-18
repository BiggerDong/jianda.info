@extends('layouts.app')
@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-8">
                <div class="notifications" style="border-radius: 5px;">
                    <div class="title" style="margin-bottom: -10px;">消息通知
                        @if($user->unreadNotifications->count() > 0)
                        <span>({{ $user->unreadNotifications->count() }})</span>
                        @endif
                        <a href="/notifications/read" class="btn btn-sm btn-primary pull-right"
                           style="margin-top: -5px;border: none;">全标已读</a>
                    </div>
                    <hr>
                    <div class="lists">
                        @foreach($user->notifications as $notification)
                            @include('notifications.'.snake_case(class_basename($notification->type)))
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.listli').mouseover(function () {
            $(this).css('cursor','pointer')
        }).mouseout(function () {
            $(this).css('cursor','default')
        });

        $('.listli').click(function () {
            var href = $(this).attr('data-href');
            window.location.href = href;
        });
    </script>
@endsection