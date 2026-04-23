@component('mail::message')
# Welcome To HireHub 👋

#Thank you for your registration , make sure you input this code to verify your account

@component('mail::panel')
# {{ $code }}
@endcomponent

**This code is valid for **10 minutes.

**If you do not register, ignore this email.

@endcomponent
