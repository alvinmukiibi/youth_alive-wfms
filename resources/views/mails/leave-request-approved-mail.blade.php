@component('mail::message')
# Hello {{$user->fname}}, <br/>
Your leave request scheduled for the period between <b>{{ $leave->from }}</b> and <b>{{ $leave->to }}</b> has been fully approved.<br/><br/>

<br/>
{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
Team<br/>
{{ config('app.name') }}
@endcomponent
