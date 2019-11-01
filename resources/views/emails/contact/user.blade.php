@component('mail::message')
# Introduction

{{ $data->message }}

@component('mail::button', ['url' => config('app.url')])
Button Text
@endcomponent

@endcomponent
