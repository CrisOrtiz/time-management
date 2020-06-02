@extends('layouts.master')

@section('plugin-styles')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="{{ asset('css/icheck-bootstrap.min.css') }}">
@stop

@section('body_class', 'register-page')

@section('body')
<div class="register-box">
    <div class="card">
        <div class="register-logo">
            <a href="/"><b>Time</b>Management</a><i class="fas fa-hourglass-half fa-spin ml-4" style="color:#007ACC;"></i>
        </div>
        <!-- /.login-logo -->

        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('login') }}">Iniciar Sesion</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('register') }}">Crear cuenta</a>
                </li>
            </ul>
        </div>

        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-warning" style="color:gray;">
                @foreach ($errors->all() as $error)
                <div class="mb-1">{{ $error }}</div>
                @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre: ') }}</label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Apellido: ') }}</label>

                    <div class="col-md-8">
                        <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus data-minlength="6">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Usuario:') }}</label>

                    <div class="col-md-8">
                        <input id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username" data-minlength="6" placeholder="Para inicio de sesion">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña: ') }}</label>

                    <div class="col-md-8">
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="6 carateres minimo">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña:') }}</label>

                    <div class="col-md-8">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="6 carateres minimo">
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Registrarse') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.register-card-body -->
    </div>
</div>

@stop

@section('adminlte_js')
@yield('js')
@stop