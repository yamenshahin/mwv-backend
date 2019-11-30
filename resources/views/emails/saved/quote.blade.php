@component('mail::message')
# Here is your quote from Hello Vans. Below is the quote and it's still valid and can be booked.
<h1><b>Total £{{$data->total}}</b><br/>Includes VAT &amp; booking fee<br/>For the first <strong>{{$data->job_meta['totalTime']}} hours</strong> and then <strong>£{{$data->price['additionalTimePrice']}}</strong> per half hour</h1>
<h2>Driver info:</h2>
<h3>Name: {{$data->user['name']}}</h3>
<img src="{{env('SITE_STORAGE_MAIN_URL')}}{{$data->placeFile['url']}}" alt="Driver Image" style="max-width:200px; height:auto;">

<h4>Addresses:</h4>
<h5>Collection:</h5> 
<p>Postcode: {{$data->job_meta['collection']['postcode']}}</p>
<p>Address: {{$data->job_meta['collection']['address']}}</p> 
<p>City: {{$data->job_meta['collection']['city']}}</p>
<p>Stairs: @switch($data->job_meta['collection']['stairs'])
    @case(0)
        no flights of stairs</p>
        @break

    @case(1)
        1 flight of stairs</p>
        @break
    @case(2)
        2 flights of stairs</p>
        @break

    @case(3)
        3 flights of stairs</p>
        @break
    @case(4)
        4 flights of stairs</p>
        @break

    @case(5)
        5 flights of stairs</p>
        @break
    @case(6)
        6 flights of stairs</p>
        @break

    @case(7)
        7 flights of stairs</p>
        @break
    @case(8)
        8 flights of stairs</p>
        @break
    @case(9)
        lift</p>
        @break

    @default
        </p>
@endswitch

<h5>Delivery:</h5> 
<p>Postcode: {{$data->job_meta['delivery']['postcode']}}</p>
<p>Address: {{$data->job_meta['delivery']['address']}}</p> 
<p>City: {{$data->job_meta['delivery']['city']}}</p>
<p>Stairs: @switch($data->job_meta['delivery']['stairs'])
    @case(0)
        no flights of stairs</p>
        @break

    @case(1)
        1 flight of stairs</p>
        @break
    @case(2)
        2 flights of stairs</p>
        @break

    @case(3)
        3 flights of stairs</p>
        @break
    @case(4)
        4 flights of stairs</p>
        @break

    @case(5)
        5 flights of stairs</p>
        @break
    @case(6)
        6 flights of stairs</p>
        @break

    @case(7)
        7 flights of stairs</p>
        @break
    @case(8)
        8 flights of stairs</p>
        @break
    @case(9)
        lift</p>
        @break

    @default
        </p>
@endswitch

<h5>Waypoints:</h5>
@foreach ($data->job_meta['waypoints'] as $waypoint)
<p>Postcode: {{$waypoint['postcode']}}</p>
<p>Address: {{$waypoint['address']}}</p> 
<p>City: {{$waypoint['city']}}</p>
<p>Stairs: @switch($waypoint['stairs'])
    @case(0)
        no flights of stairs</p>
        @break

    @case(1)
        1 flight of stairs</p>
        @break
    @case(2)
        2 flights of stairs</p>
        @break

    @case(3)
        3 flights of stairs</p>
        @break
    @case(4)
        4 flights of stairs</p>
        @break

    @case(5)
        5 flights of stairs</p>
        @break
    @case(6)
        6 flights of stairs</p>
        @break

    @case(7)
        7 flights of stairs</p>
        @break
    @case(8)
        8 flights of stairs</p>
        @break
    @case(9)
        lift</p>
        @break

    @default
        </p>
@endswitch
   
@endforeach

<h4>Others info:</h4>
<p>Van Size: @switch($data->job_meta['vanSize'])
    @case(1)
        small</p>
        @break
    @case(2)
        medium</p>
        @break

    @case(3)
        large</p>
        @break
    @case(4)
        giant</p>
        @break

    @default
        </p>
@endswitch

<p>Helpers Required: @switch($data->job_meta['helpersRequired'])
    @case(0)
        no help needed</p>
        @break
    @case(1)
        driver helping</p>
        @break

    @case(2)
        driver helping + 1 helper</p>
        @break
    @case(3)
        driver helping + 2 helpers</p>
        @break

    @default
        
@endswitch

<p>Note: {{$data->job_meta['description']}}</p>

<h4>Your info:</h4>
<p>Name: {{$data->job_meta['customerInfoName']}}</p>
<p>Email: {{$data->job_meta['customerInfoEmail']}}</p>
<p>Phone: {{$data->job_meta['customerInfoPhone']}}</p>


@component('mail::button', ['url' => env('APP_URL', 'https://hellovans.com/').'my-quotes'])
View Quote
@endcomponent

Thank you for taking your time to request a quote on our website,<br>
{{ env('SITE_MAIN_SIGNATURE', 'Hello Vans team') }}
@endcomponent
