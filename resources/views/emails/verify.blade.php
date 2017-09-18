@component('mail::message')
# {{ $user->name }}，

请点击下面的按钮进行账号激活操作:

@component('mail::button', ['url' => $url,'color' => 'black'])
激活账号
@endcomponent


如果你无法通过 激活账号 按钮进行激活，请尝试打开或复制以下链接到浏览器地址栏进行再次激活操作: <br>
[{{ $url }}]({{ $url }}) 。


@component('mail::subcopy')
感谢你的使用，<br>
如非本人操作，请忽略，<br>
这是一封由系统自动发出的邮件，请不要直接回复。
@endcomponent

@endcomponent
