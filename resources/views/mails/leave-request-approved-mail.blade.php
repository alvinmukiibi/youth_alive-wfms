@component('mail::message')
# Hello {{$user->fname}}, <br/>
Your leave request scheduled for the period between <b>{{ $leave->from }}</b> and <b>{{ $leave->to }}</b> has been fully approved.<br/><br/>
You now have {{ $leave->total_annual_days_remaining }} days remaining on your total annual leave days<br/><br/>
Please note that a button has appeared on your header. You are required to action the button to sign out.
<br/>
<br/>
Also note that clicking on the button will temporarily deactivate your account until your return from leave. <br/><br/>
If you need access to your account during leave, see the Human Resource Manager to activate it for you

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
Team<br/>
{{ config('app.name') }}
@endcomponent
