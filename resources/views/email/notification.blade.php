{{-- @component('mail::message')
    # {{ $details['title'] }}

    {{ $details['body'] }}

    @if (isset($details['actionText']) && isset($details['url']))
        @component('mail::button', ['url' => $details['url']])
            {{ $details['actionText'] }}
        @endcomponent
    @endif

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent --}}

<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    <h1>{{ $details['title'] }}</h1>
    <p>{{ $details['body'] }}</p>
    @if (isset($details['actionText']) && isset($details['url']))
        <a href={{ $details['url'] }} calss="btn btn-info btn-sm">{{ $details['actionText'] }}</a>
        <div class="">請盡速處理，謝謝。</div>
    @endif
</body>

</html>
