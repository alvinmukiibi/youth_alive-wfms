@component('mail::message')
Dear {{ $user->fname }}, You have a leave pending your approval on the Youth Work Flow Management System. Please action it.




Thanks,<br>
{{ config('app.name') }}
@endcomponent
