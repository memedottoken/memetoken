<!DOCTYPE html>
<html class="dark" dark lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
        <link rel="shortcut icon" href="/favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
        <link rel="manifest" href="/site.webmanifest" />
        
        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @if(request()->is('install*'))
            @vite(['resources/js/install.js', "resources/js/Pages/{$page['component']}.vue"])
        @else
             @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @endif
        @inertiaHead
        <script src="https://s3.tradingview.com/tv.js"></script>
        
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
