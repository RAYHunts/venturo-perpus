<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="favicon.ico" />
    <meta name="theme-color" content="#000000" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <base href="/" />

    {{-- This'll load our extracted and hashed CSS assets here --}}
    @env('production')
        @if (isset($ngAssets) && count($ngAssets))
            <link rel="stylesheet" href="/build/{{ $ngAssets['styles'] }}">
        @endif
    @endenv
  </head>
  <body>

    <noscript>You need to enable JavaScript to run this app.</noscript>

    <app-root></app-root>

    {{-- This'll load our hashed assets when in production --}}
    @env('production')
        @if (isset($ngAssets) && count($ngAssets))
            <script src="/build/{{ $ngAssets['runtime'] }}" defer></script>
            <script src="/build/{{ $ngAssets['polyfills'] }}" defer></script>
            <script src="/build/{{ $ngAssets['main'] }}" defer></script>
            <script src="/build/{{ $ngAssets['scripts'] }}" defer></script>
        @endif
    {{-- This'll load the development assets when in dev mode --}}
    @else
        <script src="/build/runtime.js" defer></script>
        <script src="/build/polyfills.js" defer></script>
        <script src="/build/styles.js" defer></script>
        <script src="/build/vendor.js" defer></script>
        <script src="/build/main.js" defer></script>
        <script src="/build/scripts.js" defer></script>
    @endenv
  </body>
</html>