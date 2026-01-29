<!doctype html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- metas -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Professional Portfolio Website')">
    <meta name="keywords" content="@yield('keywords', 'portfolio, personal, developer, designer, creative')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- title -->
    <title>@yield('title', config('app.name', 'Portfolio'))</title>

    <!-- favicon -->
    <link href="{{ asset('template/images/favicon.ico') }}" rel="icon" type="image/png">

    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('template/css/bootstrap.min.css') }}">

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800" rel="stylesheet">

    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/owl.theme.default.min.css') }}">

    <!-- magnific-popup CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/magnific-popup.css') }}">

    <!-- animate.min CSS -->
    <link rel="stylesheet" href="{{ asset('template/css/animate.min.css') }}">

    <!-- Font Icon Core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

  
    <!-- Core Style Css -->
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}">

    <!-- Additional Custom Styles -->
    @stack('styles')

    <!--[if lt IE 9]-->
    <script src="{{ asset('template/js/html5shiv.min.js') }}"></script>
    <!--[endif]-->

    @livewireStyles
</head>

<body>
    <!-- ====== Preloader ======  -->
    <div class="loading">
        <div class="load-circle"></div>
    </div>
    <!-- ======End Preloader ======  -->

    <!-- ====== Navigation ======  -->
    @include('components.navigation')
    <!-- ====== End Navigation ======  -->

    <!-- ====== Main Content ======  -->
    <main>
        @yield('content')
    </main>
    <!-- ====== End Main Content ======  -->

    <!-- ====== Footer ======  -->
    @include('components.footer')
    <!-- ====== End Footer ======  -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>

    <!-- bootstrap -->
    <script src="{{ asset('template/js/bootstrap.min.js') }}"></script>

    <!-- scrollIt -->
    <script src="{{ asset('template/js/scrollIt.min.js') }}"></script>

    <!-- magnific-popup -->
    <script src="{{ asset('template/js/jquery.magnific-popup.min.js') }}"></script>

    <!-- owl carousel -->
    <script src="{{ asset('template/js/owl.carousel.min.js') }}"></script>

    <!-- stellar js -->
    <script src="{{ asset('template/js/jquery.stellar.min.js') }}"></script>

    <!-- animated.headline -->
    <script src="{{ asset('template/js/animated.headline.js') }}"></script>

    <!-- jquery.waypoints.min js -->
    <script src="{{ asset('template/js/jquery.waypoints.min.js') }}"></script>

    <!-- jquery.counterup.min js -->
    <script src="{{ asset('template/js/jquery.counterup.min.js') }}"></script>

    <!-- isotope.pkgd.min js -->
    <script src="{{ asset('template/js/isotope.pkgd.min.js') }}"></script>

    <!-- validator js -->
    <script src="{{ asset('template/js/validator.js') }}"></script>

    <!-- custom script -->
    <script src="{{ asset('template/js/custom.js') }}"></script>

    <!-- Additional Custom Scripts -->
    @stack('scripts')

    @livewireScripts
</body>

</html>