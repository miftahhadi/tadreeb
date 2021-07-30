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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body>
        <div id="app">
            <base-layout 
                :side-menu="{{ json_encode(settings('admin_side_menu')) }}"
            >
                <template #logo>
                    <img src="{{ settings('app_logo') }}" height="80" alt="{{ settings('app_name') }}">
                </template>
            </base-layout>
        </div>


        <script type="text/javascript" src="/dist/js/app.js"></script>
    </body>
</html>