@extends('layouts.page')

@section('styles')
    <link rel="stylesheet" href="{{ mix('css/user/create.css') }}">
@stop

@section('scripts')
    <script>
        window.saveUserUrl = @json(route('api.user.store'));
        window.listUserUrl = @json(route('user.list'));
        window.companies = @json($companies);
    </script>
    <script src="{{ mix('js/user/create.js') }}"></script>
@stop

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Agregar Usuario</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.list') }}">Usuarios</a></li>
                    <li class="breadcrumb-item active">Agregar Usuario</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid" id="user-create">
        <form method="post" @submit.prevent="save" novalidate>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" required class="form-control" id="name" name="name" v-model="user.name">
                            </div>
                            <div class="form-group">
                                <label for="surname">Apellido</label>
                                <input type="text" required class="form-control" id="surname" name="surname" v-model="user.surname">
                            </div>
                            <div class="form-group">
                                <label for="username">Usuario</label>
                                <input type="text" required class="form-control" id="username" name="username" v-model="user.username">
                            </div>
                            <div class="form-group">
                                <label for="user_type">Tipo Usuario</label>
                                <v-select :input-id="'user_type'" :options="userTypes" v-model="user.user_type"></v-select>
                            </div>
                            <div class="form-group">
                                <label for="country">Pais</label>
                                <v-select :input-id="'country'" :options="countries" v-model="user.country"></v-select>
                            </div>
                            <div class="form-group" v-if="user.user_type && user.user_type.value !== 1">
                                <label for="company">Empresa</label>
                                <v-select :input-id="'company'" :label="'name'" :options="companies" v-model="user.company"></v-select>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" required name="password" class="form-control" v-model="user.password">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" required name="password_confirmation" class="form-control" v-model="user.password_confirmation">
                            </div>

                            <div class="form-group">
                                <label for="app_code">Codigo App</label>
                                <input type="text" required name="app_code" class="form-control" v-model="user.app_code">
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary" type="submit" :disabled="saving">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

{{--@extends('adminlte::page')--}}

{{--@section('content')--}}
{{--    <form id="form" role="form" action="{{ route('user.create')}}" method="POST">--}}
{{--        <div class="row">--}}
{{--            <div class="col-12 col-lg-6">--}}
{{--                <div class="box box-primary box-solid with-border">--}}
{{--                    <div class="box-header">--}}
{{--                        <h3>Agregar Usuario</h3>--}}
{{--                    </div>--}}
{{--                    <div class="box-body">--}}
{{--                        @if ($errors->any())--}}
{{--                            <div class="alert alert-danger">--}}
{{--                                <ul>--}}
{{--                                    @foreach ($errors->all() as $error)--}}
{{--                                        <li>{{ $error }}</li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        @if(Session::has("success"))--}}
{{--                            <div class="alert alert-success">{{ Session::get("success") }}</div>--}}
{{--                        @endif--}}
{{--                        {!! csrf_field() !!}--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name">Nombre</label>--}}
{{--                            <input type="text" required class="form-control" id="name" name="name" value="{{ old('name') }}">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="surname">Apellido</label>--}}
{{--                            <input type="text" required class="form-control" id="surname" name="surname" value="{{ old('surname') }}">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="username">Usuario</label>--}}
{{--                            <input type="text" required class="form-control" id="username" name="username" value="{{ old('username') }}">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name">Tipo Usuario</label>--}}
{{--                            <select id="user-type" name="user_type" class="form-control select2" value="{{ old('user_type') }}">--}}
{{--                                <option value="1" {{ old('user_type') === 1 ? 'selected': '' }}>Super Administrador</option>--}}
{{--                                <option value="2" {{ old('user_type') === 2 ? 'selected': '' }}>Administrador</option>--}}
{{--                                <option value="3" {{ old('user_type') === 3 ? 'selected': '' }}>Trabajador</option>--}}
{{--                                <option value="4" {{ old('user_type') === 4 ? 'selected': '' }}>Supervisor</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name">Pais</label>--}}
{{--                            <select name="country" class="form-control select2">--}}
{{--                                <option value="BO" {{ old('country') === 'BO' ? 'selected': '' }}>Bolivia</option>--}}
{{--                                <option value="BRA" {{ old('country') === 'BRA' ? 'selected': '' }}>Brazil</option>--}}
{{--                                <option value="CO" {{ old('country') === 'CO' ? 'selected': '' }}>Colombia</option>--}}
{{--                                <option value="PE {{ old('country') === 'PE' ? 'selected': '' }}">Peru</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group" id="company-form-group">--}}
{{--                            <label for="name">Empresa</label>--}}
{{--                            <select name="company" class="form-control select2">--}}
{{--                                @foreach($companies as $company)--}}
{{--                                    <option {{ old('company') === $company->id ? 'selected': '' }} value="{{ $company->id }}">{{ $company->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="name">Contraseña</label>--}}
{{--                            <input type="password" required name="password" class="form-control">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name">Confirmar Contraseña</label>--}}
{{--                            <input type="password" required name="password_confirmation" class="form-control">--}}
{{--                        </div>--}}

{{--                        <div class="form-group">--}}
{{--                            <label for="name">Codigo App</label>--}}
{{--                            <input type="text" required name="app_code" class="form-control" value="{{ old('app_code') }}">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="box-footer">--}}
{{--                        <button type="submit" class="btn btn-primary">Agregar</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--@stop--}}

{{--@section("js")--}}
{{--    <script>--}}
{{--        $(function () {--}}
{{--            $('.select2').select2();--}}
{{--            $('#user-type').on('select2:select', function (e) {--}}
{{--                if (e.params.data.id === "1") {--}}
{{--                    $('#company-form-group').hide();--}}
{{--                } else {--}}
{{--                    $('#company-form-group').show();--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@stop--}}
