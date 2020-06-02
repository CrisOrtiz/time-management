@extends('adminlte::page')

@section('content')
<div class="container-fluid">
    <div class="col-md-6">
                <!-- form start -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h1>Modificar permisos</h1>
            </div>
            <div class="box-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            @if(Session::has("success"))
            <div class="alert alert-success">{{ Session::get("success") }}</div> 
            @endif
                    <form  id="permisses-user" action="{{ route('userupdate.permission')}}" method="POST">

                    {!! csrf_field() !!}
                    @foreach($permissionall as $permission)
                    <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input class="check" type="checkbox" value="{{ $permission->id }}" name="{{$permission->name}}" {{ isset($permissionuser[$permission->id]) ? 'checked' : '' }}> {{ $permission->description }} 
                                        </label>
                                    </div>
                            </div>
                    @endforeach
                           
                            <div class="form-group">
                                 
                                <input type="hidden" name="user_id" value="{{ $user_id }}">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </div>
                     </form>
            </div>        
        </div>
    </div>
</div>

@stop       