@component('mail::message')
# Introduction

{{ $data->message }}

@component('mail::button', ['url' => config('app.url')])
Button Text
@endcomponent

Thanks,<br>
{{ env('SITE_MAIN_SIGNATURE', 'Hello Vans team') }}
@endcomponent
