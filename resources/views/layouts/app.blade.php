<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Granth') }}</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('plugin/snackbar/css/snackbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        .login_bg{
            background-image: url("{{asset('/assets/img/bg/login_bg_new1.png')}}");
            background-repeat: no-repeat;
        }
    </style>

</head>
<body class="login_bg">
<div id="app">
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
            <div class="container px-4">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-collapse-main">
                    <!-- Collapse header -->
                    <div class="navbar-collapse-header d-md-none">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="#">
                                    <img src="{{ asset('assets/img/brand/blue.png') }}">
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Header -->
{{--            <div class="separator separator-bottom separator-skew zindex-100">--}}
{{--                <svg x="0" y="0" viewBox="0 0 3000 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <polygon class="fill-default" points="0 0 3000 200 0 200"></polygon>--}}
{{--                </svg>--}}
{{--            </div>--}}

        <!-- Page content -->
        <div class="container mt-8 pb-5">
            @yield('content')
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('plugin/snackbar/js/snackbar.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script>
    $(document).ready(function () {
        var message="{{ \Session::get('success') }}";
        if(message!=''){
            successMessage(message);
        }
    });
</script>
</body>
</html>
