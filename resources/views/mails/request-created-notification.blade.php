@component('mail::message')

You have a request pending your approval on the Youth Alive Work Flow Management System


{{--  @component('mail::button', ['url' => '127.0.0.1:8000/login'])
<b>LOGIN</b>
@endcomponent  --}}

Thanks,<br>
Team, <br/>
{{ config('app.name') }}
@endcomponent
