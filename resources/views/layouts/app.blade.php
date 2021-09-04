<?php
$css = [
        "assets/css/fontawesome-free/css/all.min.css",
        "https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css",
    // "assets/js/plugins/icheck-bootstrap/icheck-bootstrap.min.css",
        "assets/js/plugins/jqvmap/jqvmap.min.css",
        "assets/css/datatables-bs4/css/dataTables.bootstrap4.min.css",
        "assets/css/datatables-responsive/css/responsive.bootstrap4.min.css",
        "assets/css/dist/adminlte.min.css",
        "assets/js/plugins/daterangepicker/daterangepicker.css",
        "assets/js/plugins/toastr/toastr.min.css",
        "assets/css/custom.css",

];

$js = [
    //"assets/js/plugins/jquery/jquery.min.js",
        "assets/js/plugins/bootstrap/js/bootstrap.bundle.min.js",
        "assets/js/plugins/daterangepicker/daterangepicker.js",
        "assets/js/plugins/bs-custom-file-input/bs-custom-file-input.min.js",
        "assets/css/datatables/jquery.dataTables.min.js",
        "assets/css/datatables-bs4/js/dataTables.bootstrap4.min.js",
        "assets/css/datatables-responsive/js/dataTables.responsive.min.js",
        "assets/css/datatables-responsive/js/responsive.bootstrap4.min.js",
        "assets/js/adminlte.min.js",
        "assets/js/demo.js",
        "assets/js/plugins/toastr/toastr.min.js"


];

?>




        <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Event') }}</title>

    <!-- Scripts -->
    <!--  <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="<?php echo URL::to('/'); ?>/assets/css/jquery.dataTables.min.css" rel="stylesheet">



    <!-- Styles -->
    <!--  <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->


    @foreach ($css as $addcss)
        @if( strstr($addcss,"http"))
            <link rel="stylesheet" type="text/css" href="{{$addcss}}" />
        @else
            <link rel="stylesheet" type="text/css" href="<?php echo URL::to('/'); ?>/{{$addcss}}" />
        @endif
    @endforeach

    <script src="<?php echo URL::to('/'); ?>/assets/js/theme_js/jquery-1.11.0.min.js"></script>

    <link href="<?php echo URL::to('/'); ?>/assets/css/bootstrap-datepicker.css" rel="stylesheet">
    <script src="<?php echo URL::to('/'); ?>/assets/js/bootstrap-datepicker.js"></script>


    <script type="text/javascript">
        var baseurl = '<?php echo URL::to('/'); ?>';

    </script>

</head>
<body>

<div id="app">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Event') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest


                </ul>
            </div>
        </div>


    </nav>

    @if (Auth::check())
            <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{URL::to('/home')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{URL::to('/event')}}" class="nav-link">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Event Management

                        </p>
                    </a>
                </li>

            </ul>
        </nav>
    </aside>
    @endif

    <div class="content-wrapper">
        @yield('content')
    </div>
</div>

@foreach ($js as $addjs)
    @if( strstr($addjs,"http") )

        <script type="text/javascript" src="{{$addjs}}" ></script>
    @else
        <script type="text/javascript" src="<?php echo URL::to('/'); ?>/{{$addjs}}" ></script>
    @endif
@endforeach

</body>
</html>
