@component('mail::message')
Hello {{ $user  }}, <br/>
The token for approving the request is <b>{{ $token->token }}</b> <br>
Please note that the token shall expire at {{ date('d-M-Y H:i:s', strtotime($token->expiry_date)) }}

Thanks,<br>
Team<br>
{{ config('app.name') }}
@endcomponent
