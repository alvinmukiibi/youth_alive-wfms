@component('mail::message')
<b>Hello! {{ $user->fname }}</b> <br/>
You are receiving this email because we received a password reset request for your account.<br/><br/>

@component('mail::button', ['url' => 'http://127.0.0.1:8000/password/reset/'.$token1.'/'.$token2])
Reset Password
@endcomponent

This password reset link will expire in 60 minutes.<br/><br/>

If you did not request a password reset, no further action is required. <br/><br/>



Thanks,<br>
{{ config('app.name') }}
@endcomponent
