<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Bakery - @yield('title')</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/landing.css') }}">
    @stack('styles')
</head>

<body>
    <div id="main-app">
        <v-app>
			@include('common.error-snackbar')
			<v-container fluid fill-height id="main-bg">
                @yield('content')
            </v-container>
        </v-app>
    </div>
    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    <script src="{{ mix('/js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
