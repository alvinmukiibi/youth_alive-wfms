@component('mail::message')
Hello <b>{{ $user->fname }}</b>,  <br/>
You have just signed into the WorkFlow Management System.
<p>If its not you, please click on the button below to lock your account. The account will be unlocked once you change your password</p>

<br/>
<p>If it is you, please ignore this message!!</p>

Thanks,<br>
Team<br>
{{ config('app.name') }}
@endcomponent
