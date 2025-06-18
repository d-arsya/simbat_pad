<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" type="image/png" href="{{ Storage::url(App\Models\Profile::first()->logo) }}">
         @php
            $profile = App\Models\Profile::first();
            $logoPath = $profile && $profile->logo && Storage::exists($profile->logo)
                        ? Storage::url($profile->logo)
                        : asset('assets/logo.jpg');
        @endphp
        <link rel="icon" type="image/png" href="{{ $logoPath }}">
        <title>{{ $title ?? 'SIMBAT' }}</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>

    <body class="flex min-h-screen flex-col items-center justify-center">
        {{--  <img src="{{ Storage::url(App\Models\Profile::first()->logo) }}" class="w-18" alt="" />  --}}
        <img src="{{ $logoPath }}" class="w-18" alt="" />
        @session('success')
        @include('components.toast_success')
    @endsession
    @session('error')
        @include('components.toast_error')
    @endsession
        @yield('container')
    </body>
</html>
