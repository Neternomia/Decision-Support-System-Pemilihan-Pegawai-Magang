<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="{{ asset('asset/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <!-- Custom Styles -->
    <link href="{{ asset('asset/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/dashboard.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        @include('partials.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Navbar -->
                @include('partials.navbar')

                <!-- Main Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('asset/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('asset/js/charts.js') }}"></script>
    @stack('scripts')
</body>

</html>
