@component('mail::message')
# Introduction

From: {{ $data->name }}

Email: {{ $data->email }}

Phone: {{ $data->phone }}

Role: {{ $data->role }}

Subject: {{ $data->subject }}

{{ $data->message }}

@endcomponent
