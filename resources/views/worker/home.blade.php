@extends('layouts.worker-page')

@section('styles')

@stop

@section('scripts')
<script>
    window.domainUrl = "{!! Request::url() !!}";
    window.updatePreferredUrl = "{!! route('worker.update.preferred') !!}";
    window.updateUserDataUrl = "{!! route('worker.update.data') !!}";
    window.updateUserPasswordUrl = "{!! route('worker.update.password') !!}";
    window.user = @json($user);
</script>
<script src="{{ mix('js/worker/home.js') }}"></script>

@stop

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Ajustes</h1>
        </div>
    </div>
    @if(Session::has("success"))
    <div class="col-12">
        <div class="alert alert-success alert-dismissible mb-0 mt-3">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <div>{{ Session::get("success") }}</div>
        </div>
    </div>
    @endif
</div>
@stop

@section('content')
<div class="worker-home-container" id="worker-home">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 d-flex justify-content-center">
                <div class="card col-4">
                    <!-- /.card-header -->
                    <div class="card-body d-flex justify-content-center">
                        <div class="section-container" style="width:100%">
                            <h4>Cuantas horas prefiero trabajar al dia:</h4>
                            <div class="prefered-working-hours-per-day--sublabel"><span>
                                    <h2 style="color:#007ACC">@{{ user.preferred_working_hours_per_day }} horas</h2>
                                </span></div>
                            <div id="slider">
                                <vue-slider ref="slider" v-model="user.preferred_working_hours_per_day" tooltip="none" :min="1" :max="24" style="width:100%"></vue-slider>
                                <span style="float:left">1</span><span style="float:right">24</span>
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block mt-5" type="button" @click="updatePreferred" style="width:40%">Confirmar</button>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="card col-4">
                    <!-- /.card-header -->
                    <div class="card-body d-flex justify-content-center">
                        <div class="section-container" style="width:100%">
                            <h4>Mis Datos:</h4>
                            <div class="row" style="display:flex;">
                                <span class="col-4 float-right">Nombre:</span>
                                <label for="name" class="col-7">@{{ user.name }}</label>
                            </div>
                            <div class="row" style="display:flex; justify-content:flex-start;">
                                <span class="col-4 float-right">Apellido:</span>
                                <label for="surname" class="col-7">@{{ user.surname }}</label>
                            </div>
                            <div class="row" style="display:flex; justify-content:flex-start;">
                                <span class=" col-4 float-right">nombre de usuario:</span>
                                <label for="username" class="col-7">@{{ user.username }}</label>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <div class="card col-4">
                <!-- /.card-header -->
                <div class="card-body d-flex justify-content-center">
                    <div class="section-container" style="width:100%">
                        <h4>Actualizar mis datos:</h4>
                        <div class="row" style="display:flex; justify-content:center;">
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text" style="width:150px" id="basic-addon1">Nombre:</span>
                                <div class="" style="width:50%">
                                    <input type="text" class="form-control" name="input-spinner" value="user.name" v-model="user.name">
                                </div>
                            </div>
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text" style="width:150px" id="basic-addon1">Apellido:</span>
                                <div class="" style="width:50%">
                                    <input type="text" class="form-control" name="input-spinner" value="user.surname" v-model="user.surname">
                                </div>
                            </div>
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text" style="width:150px" id="basic-addon1">Usuario:</span>
                                <div class="" style="width:50%">
                                    <input type="text" class="form-control" name="input-spinner" value="user.username" v-model="user.username">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mt-4">
                                <button class="btn btn-primary btn-block" type="button" @click="updateUserData()">Actualizar datos</button>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <div class="card col-4">
                <!-- /.card-header -->
                <div class="card-body d-flex justify-content-center">
                    <div class="section-container" style="width:100%">
                        <h4>Cambiar contraseña:</h4>
                        <div class="row" style="display:flex; justify-content:center;">
                            <div class="input-group-prepend mb-2">
                                <span class="input-group-text" style="width:200px;color:red" id="basic-addon1">Antigua contraseña:</span>
                                <div style="width:50%">
                                    <input type="password" class="form-control" name="input-spinner" v-model="oldPassword" required>
                                </div>
                            </div>
                            <div class="input-group-prepend mb-2 float-left">
                                <span class="input-group-text" style="width:200px;color:green" id="basic-addon1">Nueva contraseña:</span>
                                <div style="width:50%">
                                    <input type="text" class="form-control" name="input-spinner" v-model="newPassword" required placeholder="6 caracteres minimo">
                                </div>
                            </div>
                            <div class="input-group-prepend mb-2 float-left">
                                <span class="input-group-text" style="width:200px;color:green" id="basic-addon1">Repite nueva contraseña:</span>

                                <div style="width:50%">
                                    <input type="text" class="form-control" name="input-spinner" v-model="newPasswordRepeat" required placeholder="6 caracteres minimo">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mt-4 float-left">
                                <button class="btn btn-warning btn-block" type="button" @click="updateUserPassword()">Cambiar contraseña</button>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
@stop