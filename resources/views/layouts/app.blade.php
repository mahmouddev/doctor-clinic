<!doctype html>
<html lang="{{app()->getLocale()}}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="apple-touch-icon" sizes="76x76" href="/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/favicon-16x16.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>clinic</title>
    <meta name="title" content="clinic">

    @livewireStyles
    @vite('resources/css/dashboard.css')
    <style type="text/css">
    html {
            --dir : {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr'}};
            --text-dir:{{ app()->getLocale() == 'ar' ? 'right' : 'left'}} ;
        }
        body {
            --bg-main: #fff;
            --bg-second: #f4f4f4;
            --font-1: #333333;
            --font-2: #555555;
            --border-color: #dddddd;
            --main-color: #0194fe;
            --main-color-flexable: #0194fe;
            --scroll-bar-color: #d1d1d1;
        }
        body.night {
            --bg-main: #1c222b;
            --bg-second: #131923;
            --font-1: #fff;
            --font-2: #e3e3e3;
            --border-color: #33343b;
            --main-color: #0194fe;
            --main-color-flexable: #15202b;
            --scroll-bar-color: #505050;
        }
    </style>
    @yield('styles')
</head>
<body style="background:#eef4f5;margin-top: 65px;" class="body">
    <style type="text/css">
        #toast-container>div {
            opacity: 1;
        }
    </style>
    @yield('after-body')
    <div id="app">
        <div id="body-overlay"onclick="document.getElementById('aside-menu').classList.toggle('active');document.getElementById('body-overlay').classList.toggle('active');"></div>
        <x-navbar />
        <main class="p-0 font-2">
            @yield('content')
        </main>
        <x-footer />
    </div>
    @vite('resources/js/dashboard.js')

    @yield('scripts')
    @stack('scripts')
</body>
</html>
