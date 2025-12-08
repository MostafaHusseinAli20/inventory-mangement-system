<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper overflow-hidden">

        @include('layouts.main-header')
        @include('layouts.main-sidebar')

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            {{-- @include('layouts.content-header') --}}
            <!-- /.content-header -->
            <section class="content">
                 <div id="app"></div>
                {{ $slot }}
            </section>
        </div>

        {{-- Footer --}}
        @include('layouts.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        {{-- Scripts --}}

        @include('layouts.scripts')
    </div>
</body>

</html>
