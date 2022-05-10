@component('mail::message')
# Email Verification

Thank you for signing up. 

<a href="{{$urlWithToken}}"> Set Up Password </a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
