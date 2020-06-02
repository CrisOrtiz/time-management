@extends('layouts.manager-page')

@section('styles')

@stop

@section('scripts')
<script>
    window.domainUrl = "{!! Request::url() !!}";
    window.getSortedUsersUrl = "{!! route('workers.sorted.get') !!}";
    window.registerUserUrl = "{!! route('manager.register') !!}";
    window.deleteUserUrl = "{!! route('manager.delete.user') !!}";
    window.updateUserUrl = "{!! route('manager.update.user') !!}";
    window.tasks = @json($tasks);
    window.user = @json($user);
    window.notes = @json($notes);
    window.users = @json($users);
</script>
<script src="{{ mix('js/manager/list.js') }}"></script>

@stop

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-12">
            <h1 class="m-0 text-dark">Usuarios</h1>
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
<div class="container-fluid" id="users">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="float:right" class="mb-4">
                            <button class="btn btn-success btn-md" type="button" v-on:click="showNewUserModal()">Nuevo usuario<i class="fa fa-plus ml-2"></i></button>
                        </div>
                        <table class="table table-md table-stripped table-bordered" id="tasks-table" style="text-align:center;">
                            <thead style="color:white; background-color:#007BFF">
                                <tr>
                                    <th scope="col" style="width:20%">Nombres <i v-on:click="onChangeNameSort()" style="color:white" v-bind:class="{'fa fa-sort-up ml-2': sort=='asc',  'fa fa-sort-down ml-2': sort=='desc'}" aria-hidden="true"></i></th>
                                    <th scope="col" style="width:20%">Apellidos</th>
                                    <th scope="col" style="width:20%">Usuario</th>
                                    <th scope="col" style="width:20%">Tipo de usuario</th>
                                    <th scope="col" colspan="2" style="width:5%">Opciones</th>
                                </tr>
                            </thead>
                            <tbody style="font-weight:bold;margin: 0 auto;font-size:115%;color:gray;">
                            <paginate name="users" :list="users" :per="showNumber">
                                <tr v-for="user in paginated('users')">
                                    <td>@{{ user.name }}</td>
                                    <td>@{{ user.surname }}</td>
                                    <td>@{{ user.username }}</td>
                                    <td v-if="user.user_type == 2">Manager</td>
                                    <td v-if="user.user_type == 3">Usuario</td>
                                    <td class="d-flex justify-content-md-between" colspan="2">
                                        <button class="btn btn-primary btn-edit btn-md m-1" type="button" v-on:click="showEditUserModal(user);"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-delete btn-md m-1" type="button" v-on:click="confirmUserDelete(user);"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>

                        <div style="float:left" class="ml-2">
                            <label>Mostrar:</label>
                            <select v-model="showNumber">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                        <div style="float:right">
                            <paginate-links for="users" :classes="{'ul': 'pagination', 'li': 'page-item', 'a': 'page-link'}" :show-step-links="true" :step-links="{next: '>>',prev: '<<'}"></paginate-links>
                        </div>
                    </div>
                </div><!-- /.card-body -->
            </div>
        </div>
    </div>




    <!-- Modal Edit user-->
    <div class="modal fade" id="edit-user-modal" tabindex="-1" role="dialog" aria-labelledby="edit-task-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Editar Usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="modal-data-container">
                        <div class="info-row">
                            <div style="width:100%;" class="form">
                                @csrf

                                <div class="form-group row mt-2">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre: ') }}</label>

                                    <div class="col-md-5">
                                        <input v-model="editUser.name" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Apellido: ') }}</label>

                                    <div class="col-md-5">
                                        <input v-model="editUser.surname" id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus data-minlength="6">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Usuario:') }}</label>

                                    <div class="col-md-5">
                                        <input v-model="editUser.username" id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username" data-minlength="6" placeholder="Para inicio de sesion">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="user-type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de usuario:') }}</label>
                                    <div class="col-md-5">
                                        <select name="user-type" id="user-type" class="form-control" required v-model="editUser.user_type">
                                            <option value="2">Manager</option>
                                            <option value="3">Usuario</option>
                                        </select>
                                    </div>
                                </div>

                                <div v-if="editUser.user_type == 3" class="form-group row">
                                    <label for="preferred_working_hours_per_day" class="col-md-4 col-form-label text-md-right">{{ __('Horas preferidas de trabajo:') }}</label>

                                    <div class="col-md-5 mt-3">
                                        <input v-model="editUser.preferred_working_hours_per_day" id="preferred_working_hours_per_day" type="number" class="form-control" name="preferred_working_hours_per_day" min="1" max="24">
                                    </div>
                                </div>

                                <label for="passwords" class=" text-md-left" style="color:#007BFF">Desea cambiar la contraseña:</label>
                                <input type="checkbox" value="false" v-model="changePassword">
                                <div v-if="changePassword == true">
                                    <div class="form-group row">
                                        <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Nueva contraseña: ') }}</label>

                                        <div class="col-md-5">
                                            <input v-model="editUser.password" id="password" type="text" class="form-control" name="password" required autocomplete="new-password" placeholder="6 carateres minimo">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar nueva contraseña:') }}</label>

                                        <div class="col-md-5 mt-3">
                                            <input v-model="editUser.password_confirm" id="password-confirm" type="text" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="6 carateres minimo">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-4 offset-md-4">
                                        <button class="btn btn-success" @click="updateUser()">
                                            {{ __('Actualizar') }}
                                        </button>
                                    </div>
                                </div>
                                <span class="loan-modal-data"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal New Task-->
    <div class="modal fade" id="new-user-modal" tabindex="-1" role="dialog" aria-labelledby="new-task-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="modal-data-container">
                        <div class="info-row">
                            <div style="width:100%;" class="form">
                                @csrf

                                <div class="form-group row mt-2">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre: ') }}</label>

                                    <div class="col-md-5">
                                        <input v-model="newUser.name" id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Apellido: ') }}</label>

                                    <div class="col-md-5">
                                        <input v-model="newUser.surname" id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus data-minlength="6">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Usuario:') }}</label>

                                    <div class="col-md-5">
                                        <input v-model="newUser.username" id="username" type="username" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username" data-minlength="6" placeholder="Para inicio de sesion">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña: ') }}</label>

                                    <div class="col-md-5">
                                        <input v-model="newUser.password" id="password" type="text" class="form-control" name="password" required autocomplete="new-password" placeholder="6 carateres minimo">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar contraseña:') }}</label>

                                    <div class="col-md-5 mt-3">
                                        <input v-model="newUser.password_confirm" id="password-confirm" type="text" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="6 carateres minimo">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="user-type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de usuario:') }}</label>
                                    <div class="col-md-5">
                                        <select name="user-type" id="user-type" class="form-control" required v-model="newUser.user_type">
                                            <option value="2">Manager</option>
                                            <option value="3">Usuario</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-4 offset-md-4">
                                        <button class="btn btn-success" @click="registerUser()">
                                            {{ __('Registrar') }}
                                        </button>
                                    </div>
                                </div>

                                <span class="loan-modal-data"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop