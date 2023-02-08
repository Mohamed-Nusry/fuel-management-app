<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    {{-- Stylesheets --}}
    @include('layouts.assets.css.fontawesome')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('custom/front.css') }}">

    @include('layouts.assets.css.overlayscrollbar')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" rel="stylesheet">

    @stack('page_css')


    <style>
        .sub-active {
            background-color: #007bff !important;
            color: #fff !important;
        }

        .centered-div {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .select-picker-border {
            border: 1px solid !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    {{-- <img src="{{ asset('image/logo.png') }}"
                         class="user-image img-circle elevation-2" alt="User Image"> --}}
                         @if(Auth::user()->user_type != null)
                            @if(Auth::user()->user_type == 1)    
                                <span class="d-none d-md-inline">{{ Auth::user()->name }}  (Role - Head)</span>
                            @else

                                @if(Auth::user()->user_type == 2)    
                                    <span class="d-none d-md-inline">{{ Auth::user()->name }}  (Role - Manager)</span>
                                @else

                                
                                    @if(Auth::user()->user_type == 3)    
                                        <span class="d-none d-md-inline">{{ Auth::user()->name }}  (Role - Customer)</span>
                                    @else   
                                        <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                                    @endif
                                    

                                @endif
                                

                            @endif

                         @else
                            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                         @endif
                   
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{ asset('image/logo.png') }}"
                             class="img-circle elevation-2"
                             alt="User Image">
                        <p>
                            {{ Auth::user()->name }}
                            <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        {{-- <a href="#" class="btn btn-default btn-flat">Profile</a> --}}
                        <a href="#" class="btn btn-default btn-flat "
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Sign out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.5
        </div>
        <strong>Copyright &copy; 2023 FuelIn.</strong> All rights reserved.
    </footer>
</div>

{{-- Javascripts --}}
@include('layouts.assets.js.jquery')
@include('layouts.assets.js.popper')
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('custom/dashboard.js') }}"></script>
@include('layouts.assets.js.momentjs')
@include('layouts.assets.js.overlayscrollbar')
@include('components.reuse-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

@stack('page_scripts')
</body>
</html>
