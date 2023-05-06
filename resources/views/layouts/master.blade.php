<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ getSingleMedia(settingSession('get'),'site_favicon',null) }}" rel="icon" type="image/png">

    <title>{{ $pageTitle ?? config('app.name', 'Granth') }}</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Icons -->
    <link href="{{ asset('assets/vendor/nucleo/css/nucleo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/custom.css') }}" rel="stylesheet">

    <link href="{{asset('plugin/calentim/css/calentim.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/plugin/rateyo/css/jquery.rateyo.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/plugin/jquery-confirm/css/jquery-confirm.min.css') }}" rel="stylesheet" type="text/css" />
    @include('partials._dynamic_styles')

    <!-- Optional header section  -->
    @yield('head_extra')
</head>

@include('partials._body')

</html>
