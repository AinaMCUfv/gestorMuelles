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
                <th scope="col" width="10%">Cancelada</th>
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
                        <th scope="row">{{ $reserva->carga == 0 ? "Carga":"Descarga"}}</th>
                        <th scope="row">{{ $reserva->fecha }}</th>
                        <th scope="row">{{ $reserva->cancelada == 1 ? "Cancelada" : "Activa" }}</th>                          
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex">
            
        </div>

    </div>
@endsection
