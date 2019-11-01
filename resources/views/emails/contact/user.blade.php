@component('mail::message')
# Introduction

{{ $data->message }}

@component('mail::button', ['url' => 'http://google.com'])
Button Text
@endcomponent

Thanks,<br>
{{ $data->signature }}
@endcomponent
