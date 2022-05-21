 @if(!isset(Auth::user()->email))
    <script>window.location="/";</script>
   @endif

@extends('layouts.app-master')

@section('content')

 
    
    <h1 class="mb-3">Reservas de muelle</h1>

    <div class="bg-light p-4 rounded">
        <h1>Reservas</h1>
        <div class="lead">
            Gestor de reservas.
            @if(Auth::user()->rol != "Trabajador")
                <a href="{{ route('reservas.create') }}" class="btn btn-primary btn-sm float-right">Añadir reserva</a>
            @endif
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" width="1%">ID</th>
                <th scope="col" width="15%">Num Pedido</th>
                <th scope="col" width="10%">Tipo Vehiculo</th>
                <th scope="col" width="10%">Matricula</th>
                <th scope="col" width="10%">Carga/descarga</th>
                <th scope="col" width="20%">Fecha</th>
                <th scope="col" width="10%">Id usuario</th>
                <th scope="col" width="1%" colspan="3"></th>    
            </tr>
            </thead>
            <tbody>
               @foreach($reservas as $reserva)
                    <tr>
                        <th scope="row">{{ $reserva->id }}</th>
                        <th scope="row">{{ $reserva->numpedido }}</th>
                        <th scope="row">{{ $reserva->tipov }}</th>
                        <th scope="row">{{ $reserva->matricula }}</th>
                        <th scope="row">{{ $reserva->carga }}</th>
                        <th scope="row">{{ $reserva->fecha }}</th>
                        <th scope="row">{{ $reserva->idusuario }}</th>
                        @if(Auth::user()->rol != "Trabajador")
                            <!--<td><a href="" class="btn btn-warning btn-sm">Show</a></td>
                            {{ Log::info($reserva->fecha) }}
                            {{ Log::info(date('Y-m-d H:i:s')) }}-->
                            
                            @if($reserva->fecha >= date('Y-m-d H:i:s'))
                                <td><a href="{{ route('reservas.edit', $reserva->id) }}" class="btn btn-info btn-sm">Edit</a></td>
                            @else
                                 <td><a disabled class="btn btn-secondary btn-sm">Edit</a></td>
                            @endif
                        @endif                        
                        @if(Auth::user()->rol == "Admin" || Auth::user()->rol == "Conductor")
                            <td>
                                {!! Form::open(['method' => 'DELETE','route' => ['reservas.destroy', $reserva->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </td>
                        @endif
                        
                        
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            
        </div>

    </div>
@endsection
