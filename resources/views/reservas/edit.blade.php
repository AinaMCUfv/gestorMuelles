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
                   <select class="form-control" name="fecha" required>
                         <option selected value="">Seleccione una opción</option>
                         <option value="6">6:00-7:00</option>
                         <option value="7">7:00-8:00</option>
                         <option value="8">8:00-9:00</option>
                         <option value="9">9:00-10:00</option>
                         <option value="10">10:00-11:00</option>
                         <option value="11">11:00-12:00</option>
                         <option value="12">12:00-13:00</option>
                         <option value="13">13:00-14:00</option>
                     </select>
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
