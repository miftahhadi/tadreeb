<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }} @hasSection ('area') - @yield('area') @endif | {{ settings('app_name') }}</title>

        <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

        <!-- Stylesheet -->
        <link rel="stylesheet" href="{{ asset('css/buefy.css') }}">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body>
        <section class="section">
            <div class="container">
                @yield('main')
            </div>
        </section>

        <script type="text/javascript" src="/dist/js/app.js"></script>
    </body>
</html>