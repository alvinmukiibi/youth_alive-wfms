@component('mail::message')
Hello {{ $user->fname }}, You have just logged in the WorkFlow Management System.

The body of your message.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
