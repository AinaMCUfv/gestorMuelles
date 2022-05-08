@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h1>Añade reserva</h1>
        <div class="lead">
            Añade una nueva reserva a tu listado.
        </div>

        <div class="container mt-4">
            <form method="POST" action="{{ url('/reservas/darAltaReserva') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Codigo</label>
                    <input value="{{ old('name') }}" 
                        type="number" 
                        class="form-control" 
                        name="codigo" 
                        placeholder="Codigo" required>

                    @if ($errors->has('name'))
                        <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo Vehículo</label>
                     <select class="form-control" name="tipo" required>
                         <option selected value="Trailer">Trailer</option>
                         <option value="Lona">Lona</option>
                         <option value="Furgoneta">Furgoneta</option>
                     </select> 
                </div>
                <div class="mb-3">
                    <label for="carga" class="form-label">Acción</label>
                    <select class="form-control" name="carga" required>
                         <option selected value="0">Carga</option>
                         <option value="1">Descarga</option>
                     </select> 
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha</label>
                    <select class="form-control" name="fecha" required>
                         <option selected value="6">6:00-7:00</option>
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

                <button type="submit" class="btn btn-primary">Confirmar reserva</button>
                <a href="{{ route('reservas.index') }}" class="btn btn-default">Volver</a>
            </form>
        </div>

    </div>
@endsection
