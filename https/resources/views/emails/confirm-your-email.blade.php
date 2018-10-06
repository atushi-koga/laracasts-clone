@component('mail::message')
# One more step before joining Bahdcasts !

We need you to confirm your email

@component('mail::button', ['url' => "/register/confirm?token={$user->confirm_token}"])
Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
