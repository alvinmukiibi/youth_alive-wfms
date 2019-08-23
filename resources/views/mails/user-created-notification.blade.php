@component('mail::message')

Hello <b>{{ $user->firstname }}</b>,<br>
Your account has been created on The Youth Alive Work Flow Management System<br>
Please {{ __('use the default') }} password of <i><b>{{ 'youthalive' }}</b></i><br/>
You are expected to change your password to one of your choice {{ __('on') }} first login<br/>
{{ __('Use the link below to login') }}


@component('mail::button', ['url' => '127.0.0.1:8000/login'])
<b>LOGIN</b>
@endcomponent

Thanks,<br>
Team, <br/>
{{ config('app.name') }}
@endcomponent
