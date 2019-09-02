@component('mail::message')

You request on the Youth Alive Work Flow Management System has been changed status. Please review


{{--  @component('mail::button', ['url' => '127.0.0.1:8000/login'])
<b>LOGIN</b>
@endcomponent  --}}

Thanks,<br>
Team, <br/>
{{ config('app.name') }}
@endcomponent
