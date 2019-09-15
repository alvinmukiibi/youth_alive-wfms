@component('mail::message')

Hello <b>{{ $user->firstname }}</b>,<br>
Your account has been created on The Youth Alive Work Flow Management System<br>
Please {{ __('use the default') }} password of <i><b>{{ 'youthalive' }}</b></i><br/>
You are expected to change your password to one of your choice {{ __('on') }} first login<br/>
{{ __('Use the link below to verify your email before loggin in') }}

@component('mail::button', ['url' => 'http://127.0.0.1:8000/verify/email/'. $link])
<b>VERIFY EMAIL</b>
@endcomponent

Thanks,<br>
Team, <br/>
{{ config('app.name') }}
@endcomponent
