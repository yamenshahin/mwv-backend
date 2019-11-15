@component('mail::message')
# Hello {{ $data->name }},

{{ $data->message }}

@component('mail::button', ['url' => config('app.url')])
Visit Hello Vans
@endcomponent

Thanks,<br>
{{ env('SITE_MAIN_SIGNATURE', 'Hello Vans team') }}
@endcomponent
