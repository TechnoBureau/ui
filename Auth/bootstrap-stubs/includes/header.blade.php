<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#590C12"/>
    <link rel="apple-touch-icon" href="/img/apple-touch-icon-192x192.png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechnoBureau') }}</title>
    <link rel="manifest" type="application/manifest+json" href="/manifest.webmanifest">
    {!! SEO::generate(true) !!}
    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <link href="{{ mix('css/technobureau.css') }}" rel="stylesheet">

</head>        
