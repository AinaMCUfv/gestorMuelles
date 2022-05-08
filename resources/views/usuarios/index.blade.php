 @if(!isset(Auth::user()->email))
    <script>window.location="/";</script>
   @endif

@extends('layouts.app-master')

@section('content')

 
    
    <h1 class="mb-3">Usuarios de muelle</h1>

    <div class="bg-light p-4 rounded">
        <h1>usuarios</h1>
        <div class="lead">
            Gestor de usuarios.
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm float-right">Añadir usuario</a>
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">ID</th>
                <th scope="col" width="10%">Nombre</th>
                <th scope="col" width="10%">Email</th>
                <th scope="col" width="10%">Rol</th>
                <th scope="col" width="5%">Activo</th>
                <th scope="col" width="1%" colspan="3"></th>    
            </tr>
            </thead>
            <tbody>
               @foreach($usuarios as $usuario)
                    <tr>
                        <th scope="row">{{ $usuario->id }}</th>
                        <th scope="row">{{ $usuario->name }}</th>
                        <th scope="row">{{ $usuario->email }}</th>
                        <th scope="row">{{ $usuario->rol }}</th>
                        <th scope="row">{{ $usuario->borrado }}</th>
                        <td><a class="btn btn-info btn-sm">Edit</a></td>
                        <td>
                            {!! Form::open(['method' => 'DELETE','route' => ['usuarios.destroy', $usuario->id],'style'=>'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            
        </div>

    </div>
@endsection
