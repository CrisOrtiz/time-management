@extends('layouts.master')

@section('plugin-styles')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
@stop

@section('body_class', 'login-page')

@section('body')
<div class="login-box">
    <div class="card">
        <div class="login-logo">
            <a href="/"><b style="color:#007ACC">Time</b>Management</a><i class="fas fa-hourglass-half fa-spin ml-4" style="color:#007ACC;"></i>
        </div>
        <!-- /.login-logo -->

        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('login') }}">Iniciar Sesion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('register') }}">Crear cuenta</a>
                </li>
            </ul>
        </div>

        <div class="card-body login-card-body">
            @if (session('info'))
            <div class="alert alert-success" role="alert">
                <div class="mb-1">{{ session('info') }}</div>
            </div>
            @endif
            @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <div class="mb-1">{{ $error }}</div>
                @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('login') }}" method="post" novalidate>
                {{ csrf_field() }}
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control {{ $errors->has('username') ? 'has-error' : '' }}" value="{{ old('username') }}" placeholder="Usuario">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @if ($errors->has('username'))
                    <div class="invalid-feedback">
                        {{ $errors->first('username') }}
                    </div>
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'has-error' : '' }}" placeholder="Contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Recordarme
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@stop

@section('adminlte_js')
@yield('js')
@stop