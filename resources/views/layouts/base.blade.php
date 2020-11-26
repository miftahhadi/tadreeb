<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-alpha.7
* @link https://github.com/tabler/tabler
* Copyright 2018-2019 The Tabler Authors
* Copyright 2018-2019 codecalm.net Paweł Kuna
* Licensed under MIT (https://tabler.io/license)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>

    <title>
        {{ $title }} 

        @hasSection ('area')
            - @yield('area')
        @endif
        
        | {{ settings('app_name') }}
    </title>

    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <meta name="msapplication-TileColor" content="#206bc4"/>
    <meta name="theme-color" content="#206bc4"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="MobileOptimized" content="320"/>
    <meta name="robots" content="noindex,nofollow,noarchive"/>
    <link rel="icon" href="/favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('head-script')
      <!-- CSS files -->
      <link href="/dist/css/tabler.css" rel="stylesheet"/>
      <!-- Arabic Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Aref+Ruqaa:wght@400;700&family=Cairo:wght@200;300;400;600;700;900&family=Lateef&family=Markazi+Text:wght@400;500;600;700&family=Scheherazade:wght@400;700&display=swap" rel="stylesheet"> 

      <!-- fontawesome -->
      <script src="https://kit.fontawesome.com/c62b0f450b.js" crossorigin="anonymous"></script>
    @show

    <style>
      body {
      	display: none;
      }
    </style>

  </head>
  
  <body class="antialiased @yield('body-class')">

    @yield('main')

    @stack('js')

    <script>
        document.body.style.display = "block"
    </script>

  </body>

</html>