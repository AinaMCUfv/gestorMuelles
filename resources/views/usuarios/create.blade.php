@extends('layouts.app-master')
@section('content')
<div class="bg-light p-4 rounded">
        <h1>Añade usuario</h1>
        <div class="lead">
            Añade un nuevo usuario a tu listado.
        </div>
        @if ($message = Session::get('error'))
         <div class="alert alert-danger alert-block">
          <strong>{{ $message }}</strong>
         </div>
        @endif

        <div class="container mt-4">
            <form method="POST" action="{{ url('/usuarios/darAltaUsuario') }}">
                @csrf
                   <div class="mb-3">
                       <label for="name" class="form-label">Email</label>
                       <input type="email" name="email" class="form-control" />
                   </div>
                   <div class="mb-3">
                       <label for="name" class="form-label">Nombre</label>
                       <input type="text" name="name" class="form-control" />
                   </div>
                  <div class="mb-3">
                       <label for="name" class="form-label">Password</label>
                       <input type="password" name="password" class="form-control" />
                   </div>
                   <div class="mb-3">
                       <label for="name" class="form-label">Repita password</label>
                       <input type="password" name="password2" class="form-control" />
                   </div>
                   <div class="mb-3">
                       <label for="name" class="form-label">Rol</label>
                       <select class="form-control" name="rol">
                           <option selected>Selecciona el tipo perfil:</option>
                           <option value="Conductor">Conductor</option>
                           <option value="Admin">Admin</option>
                           <option value="Trabajador">Trabajador</option>
                       </select>
                   </div>                   
                    <div class="form-group"></div>

                <button type="submit" class="btn btn-primary">Confirmar registro</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-default">Volver</a>
            </form>
        </div>

    </div>





@endsection