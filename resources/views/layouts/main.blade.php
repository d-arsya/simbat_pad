<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'SIMBAT' }}</title>
     @php
        $profile = App\Models\Profile::first();
        $logoPath = $profile && $profile->logo && Storage::exists($profile->logo)
                    ? Storage::url($profile->logo)
                    : asset('assets/logo.jpg');
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{--  <link rel="icon" type="image/png" href="{{ Storage::url(App\Models\Profile::first()->logo) }}">  --}}
    <link rel="icon" type="image/png" href="{{ $logoPath }}">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body>
    @include('components.modal')
    @include('components.sidebar')
    <div class="sm:ml-64">
        @include('components.header')
    </div>
    <div class="p-4 sm:ml-64">
        @yield('container')
    </div>
    @session('success')
        @include('components.toast_success')
    @endsession
    @if(session('error') || $errors->any())
        @include('components.toast_error')
    @endif

    <!-- Inject API Token for Frontend -->
    <script>
        // Make API token available to frontend JavaScript
        window.API_TOKEN = '{{ session('api_token') }}';

        // Helper function to get the current API token
        function getApiToken() {
            return window.API_TOKEN;
        }

        // Helper function to set up axios with authentication
        function setupAuthenticatedAxios() {
            const token = getApiToken();
            if (token) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            }
        }

        // Set up authentication when page loads
        document.addEventListener('DOMContentLoaded', function() {
            setupAuthenticatedAxios();
        });
    </script>

</body>

</html>
