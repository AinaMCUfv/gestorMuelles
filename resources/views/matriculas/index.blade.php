 @if(!isset(Auth::user()->email))
    <script>window.location="/";</script>
   @endif

@extends('layouts.app-master')

@section('content')   
    
   <div class="bg-light p-4 rounded">
        <h1 class="mb-3">Gestor matrículas</h1>
        <div class="lead">
            Inserte una matricula par validad con el sistema de reservas:
        </div>

         @if ($message = Session::get('error'))
           <div class="alert alert-danger alert-block">
            <strong>{{ $message }}</strong>
           </div>
           @endif

           @if ($message = Session::get('success'))
           <div class="alert alert alert-success alert-block">
            <strong>{{ $message }}</strong>
           </div>
           @endif

           @if (count($errors) > 0)
            <div class="alert alert-danger">
             <ul>
             @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
             @endforeach
             </ul>
            </div>
           @endif

        <div class="container mt-4">
            <form method="POST" action="{{ route('matriculas.check') }}"> 
                @csrf
                <div class="mb-3">
                    <label for="tipo" class="form-label">Inserte matricula para validar:</label>
                    <input type="text" name="matricula" class="form-control" />
                </div>

                <button type="submit" class="btn btn-primary">Validar</button>
            </form>
        </div>

    </div>
  
@endsection
