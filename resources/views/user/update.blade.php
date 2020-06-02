<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modaledit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modaledit">Modificar Usuario</h4>
            </div>
            <form id="form" role="form" action="{{ route('user.update')}}" method="POST">
            <div class="modal-body">
                <div class="container-fluid">
                
                    <div class="col-md-12">
                        
                        <div class="row">
                        {!! csrf_field() !!}
                        <input id="user_id" type="hidden" name="user_id"  value="">
                        <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                        </div>
                        <div class="form-group">
                        <label for="surname">Apellido</label>
                        <input type="text" class="form-control" id="surname" placeholder="Enter surname"
                        name="surname">
                        </div>
                        <div class="form-group">
                        <label for="username">Usuario</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter email"
                        name="username">
                        </div>
                        <div class="form-group">
                        <label>Tipo Usuario</label>
                        <select id="user_type" name="user_type" class="form-control">
                            <option value="1">Super Administrador</option>
                            <option value="2">Administrador</option>
                            <option value="3">Supervisor</option>
                            <option value="4" selected>Usuario</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label >Pais</label>
                        <select id="country" name="country" class="form-control">
                            <option value="BO">Bolivia</option>
                            <option value="BRA">Brazil</option>
                            <option value="CO">Colombia</option>
                            <option value="PE">Peru</option>
                        </select>
                        </div>
                        <div class="form-group" >
                        <label >Empresa</label>
                        <select id="company_id" name="company_id" class="form-control">
                            @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <input type="password" name="password" class="form-control" autocomplete="off">
                        <span class="help-block">Campo no obligatorio</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" class="form-control">
                        <span class="help-block">Campo no obligatorio</span>
                    </div>
                        <div class="form-group" id="app-zone">
                            <label for="app_code">Codigo App</label>
                            <input type="text" name="app_code" class="form-control" id="app_code">
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
            </form>          
        </div> 
    </div>
</div>
