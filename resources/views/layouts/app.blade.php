<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="{{ config('app.description') }}">
        <meta name="author" content="{{ config('app.author') }}">
        <title>{{ config('app.name')  }}</title>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link href="{{ asset('favicon.ico') }}" rel="icon" type="image/png">
        <!-- Fonts -->
        <!--link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"-->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="{{ asset('packages/core/main.css') }}" rel='stylesheet' />
        <link href="{{ asset('packages/daygrid/main.css') }}" rel='stylesheet' />
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css">

        <script>
            var csrfToken = "{{ csrf_token() }}";
        </script>
    </head>
    <body>
        <div id="app" class="menu4">
            @include ('layouts.partials.navigation')
            <main>
                @yield('content')
            </main>

            @include ('layouts.partials.footer')
        </div>

        <script src="{{ asset('packages/core/main.js') }}"></script>
        <script src="{{ asset('packages/interaction/main.js') }}"></script>
        <script src="{{ asset('packages/daygrid/main.js') }}"></script>
        <script src="{{ asset('packages/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('packages/bootstrap/bootstrap-notify.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    </body>
</html>
