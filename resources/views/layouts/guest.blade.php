<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>تسجيل الدخول | نظام الحسابات والمخازن</title>
    {{-- Fonts --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE-RTL/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet"
        href="{{ asset('assets/adminLTE-RTL/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE-RTL/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE-RTL/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE-RTL/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('assets/adminLTE-RTL/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE-RTL/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE-RTL/plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href="{{ asset('assets/adminLTE-RTL/dist/css/custom.css') }}">
    {{--  --}}
    {{-- <link rel="stylesheet" href="{{ mix('./resourse/css/app.css') }}" /> --}}
    {{-- Style file --}}
    <link rel="stylesheet" href="{{ asset('assets/assets/css/style.css') }}">

    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <!-- INCLUDES -->
    <link rel="stylesheet" href="{{ asset('assets/assets/css/bootstrap-table-expandable.css') }}">
    {{-- <script src="{{ asset('assets/js/bootstrap-table-expandable.js') }}"></script> --}}
    <link rel="icon" href="{{ asset('assets/assets/icons/store.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/element-plus/2.6.3/index.min.css"
        integrity="sha512-vI6rdjc41e32h4glruk6shoDda2GlpvtkMhmOY4EOfuYWlR4OArGURn7V2R8bkvDnrNuhFJYHEbM/dRYhYz3YQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>


    <div>
        {{ $slot }}
    </div>

</body>

</html>
