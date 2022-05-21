@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Cambiar contraseña</h1>
        <div class="lead">
            Cambia la password del usuario
        </div>

        <div class="container mt-4">
            <form method="POST" action="{{ route('usuarios.update',$usuario->id) }}"> 
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="tipo" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" />
                </div>
                <div class="mb-3">
                     <label for="tipo" class="form-label">Repetir Contraseña</label>
                     <input type="password" name="password2" class="form-control" />
                </div>

                <button type="submit" class="btn btn-primary">Confirmar cambio contraseña</button>
                <a href="{{ route('usuarios.index') }}" class="btn btn-default">Volver</a>
            </form>
        </div>

    </div>
@endsection
