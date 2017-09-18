@component('mail::message')
##请确保为本人，
请点击下面的按钮进行重置密码操作:

@component('mail::button', ['url' => $actionUrl,'color' => 'black'])
重置密码
@endcomponent


如果你无法通过 重置密码 按钮进行密码重置，请尝试打开或复制以下链接到浏览器地址栏进行再次重置操作: <br>
[{{ $actionUrl }}]({{ $actionUrl }}) 。


@component('mail::subcopy')
如非本人操作，请忽略，<br>
这是一封由系统自动发出的邮件，请不要直接回复。
@endcomponent

@endcomponent
