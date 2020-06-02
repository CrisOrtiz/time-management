@extends('layouts.master')

@section('body')
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- logout -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}">
                    <span style="color:#007ACC">{{ __('Cerrar Sesión') }}</span>&nbsp;<i class="fas fa-sign-out-alt" style="color:red;"></i>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link text-center">
            <span class="brand-text font-weight-bold">Time Manager</span><i class="fas fa-hourglass-half ml-3" style="color:#007ACC;"></i>
        </a>
        <a href="#" class="brand-link text-center">
            <span class="brand-text font-weight-bold"> {{ auth()->user()->name }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            @yield('sidebar', View::make('layouts.worker-sidebar'))
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            @yield('content_header')
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content" id="worker-home">
            @yield('content')
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    @include('layouts.footer')
</div>
@endsection