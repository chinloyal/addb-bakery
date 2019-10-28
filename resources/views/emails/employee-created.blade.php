@component('mail::message')
# Account created by admin

An account was created for you by the admin.
Login with these credentials
E-mail: {{ $email }}
Password: {{ $password }}

@component('mail::button', ['url' => url('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
