<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    @stack('webfont')

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/mdi/css/materialdesignicons.min.css') }}">
    @stack('icon')

    @notify_css
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    @stack('plugin-style')

    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
    <!-- OverWrite style -->
    <link rel="stylesheet" href="{{ asset('assets/css/utility.css') }}">
    <!-- Page Level Style -->
    @stack('page-style')
</head>
<body class="hold-transition @yield('body-class')">

<!-- Preloader -->
{!! \Laraflow\Laraflow\Services\Utilities\CustomHtmlService::preloader() !!}

<div class="login-box">
    <!-- login-logo -->
    <div class="login-logo">
        <a href="{{ url('/') }}">{{ config('app.name', 'Laraflow') }}</a>
    </div>
    <!-- /.login-logo -->
    @yield('content')
</div>
<!-- /.login-box -->

<div class="lockscreen-footer text-center">
    Copyright &copy; {{ date('Y') }}
    <b><a href="{{ url('/') }}" class="text-black">{{ config('backend.copyright') }}</a></b>
    <br>All rights reserved
</div>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Plugin JS -->
@stack('plugin-style')
<!-- AdminLTE App -->
<script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
<script src="{{ asset('assets/js/utility.min.js') }}"></script>
<!-- inline js -->
@notify_js
@notify_render
@stack('page-script')
</body>
</html>
