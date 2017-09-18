<li class="listli {{ $notification->unread() ? 'unread' : '' }}"
    data-href="/notifications/{{ $notification->id }}?redirect_url=/questions/{{ $notification->data['question'] }}">
    <span style="margin-left: -10px;">
        <a class="user-notify" href="/users/{{ $notification->data['id'] }}/home">{{ $notification->data['name'] }}</a> 回答了你提起的问题
        <span class="pull-right" style="font-size: 13px;margin-top: 3px;">{{ $notification->created_at->format('m-d H:i') }}</span>
    </span>
</li>