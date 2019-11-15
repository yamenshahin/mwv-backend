@component('mail::message')
# This email sent by our a user from our website page Contact Us 

From: {{ $data->name }}

Email: {{ $data->email }}

Phone: {{ $data->phone }}

Role: {{ $data->role }}

Subject: {{ $data->subject }}

{{ $data->message }}

Thanks,<br>
{{ $data->signature }}
@endcomponent
