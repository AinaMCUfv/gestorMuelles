@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Editar reserva</h1>
        <div class="lead">
            Editar una nueva reserva de tu listado.
        </div>

        <div class="container mt-4">
            <form method="POST" action="{{ route('reservas.update',$reserva->id) }}"> 
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Codigo</label>
                    <input value="{{ $reserva->numpedido }}"  
                        type="number" 
                        class="form-control" 
                        name="codigo" 
                        placeholder="Codigo" required disabled>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo Vehículo</label>
                     <input value="{{ $reserva->tipov }}"  
                        type="text" 
                        class="form-control" 
                        name="tipo" 
                        placeholder="Tipo" required disabled>
                </div>
                <div class="mb-3">
                    <label for="carga" class="form-label">Acción</label>
                    <input value="{{ $reserva->carga==0?'Carga':'Descarga' }}"  
                        type="text" 
                        class="form-control" 
                        name="carga" 
                        placeholder="Carga" required disabled>
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <input value="{{ old('fecha') }}"
                        type="number" 
                        class="form-control" 
                        name="fecha" 
                        min="0" 
                        max="24" 
                        placeholder="Hora" required>
                    @if ($errors->has('fecha'))
                        <span class="text-danger text-left">{{ $errors->first('fecha') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Confirmar edicion reserva</button>
                <a href="{{ route('reservas.index') }}" class="btn btn-default">Volver</a>
            </form>
        </div>

    </div>
@endsection
