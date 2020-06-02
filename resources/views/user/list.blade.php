@extends('layouts.page')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components/vikor-table.css') }}">
@stop

@section('scripts')
    <script>
{{--        window.userEditorUrl = "{!! route('user.editor') !!}";--}}
{{--        window.userDataUrl = "{!! route('user.data') !!}";--}}
{{--        window.domainUrl = "{!! Request::url() !!}";--}}
{{--        window.tokenCsrf = "{!! csrf_token() !!}";--}}
        window.userDatatableUrl = @json(route('user.list.datatable'));
    </script>
    <script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ mix('js/user/list.js') }}"></script>
@stop

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1 class="m-0 text-dark">Usuario</h1>
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
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Usuarios</h3>
                            <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">
                                <small class="fas fa-plus mr-1"></small>
                                Agregar Usuario
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered vikor-table" id="user-table">
                                <thead>
                                <tr>
                                    <th class="min-w-130">Nombre</th>
                                    <th class="min-w-130">Apellido</th>
                                    <th class="min-w-130">Usuario</th>
                                    <th class="min-w-130">Pais</th>
                                    <th class="min-w-130">Tipo de Usuario</th>
                                    <th class="min-w-130">Empresa</th>
                                    <th class="min-w-60"></th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@stop
