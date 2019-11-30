@component('mail::message')
# Hello {{ $data->name }},

{{ $data->message }}

@component('mail::button', ['url' => env('APP_URL', 'https://hellovans.com/')])
Visit Hello Vans
@endcomponent

Thanks,<br>
{{ env('SITE_MAIN_SIGNATURE', 'Hello Vans team') }}
@endcomponent
