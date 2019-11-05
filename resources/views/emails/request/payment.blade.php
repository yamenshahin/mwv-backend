@component('mail::message')
# Request Payment

<h3>Request payment form: </h3>
<p>ID: {{$data->id}} </p>
<p>Name: {{$data->name}}</p>
<p>Email: {{$data->email}}</p>
<p>Phone: {{$data->phone}}</p>

Thanks,<br>
{{ env('SITE_MAIN_SIGNATURE', 'Hello Vans team') }}
@endcomponent
