@component('mail::message')
Hello <b>{{ $user->fname }}</b>,  <br/>
You have just signed into the WorkFlow Management System.
<p>Time of Signin: {{ date('d-M-Y H:i:s') }}</p>
<p>To turn off these notifications, go to Dashboard >> Settings >> Receive Login Notifications</p>

<br/>
<p>If it is you, please ignore this message!!</p>

Thanks,<br>
Team<br>
{{ config('app.name') }}
@endcomponent
