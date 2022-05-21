<!DOCTYPE html>
<html>
 <head>
  <title>Registro</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style type="text/css">
   .box{
    width:600px;
    margin:0 auto;
    border:1px solid #ccc;
   }
  </style>
 </head>
 <body>
  <br />
  <div class="container box">
   <h3 align="center">Registro</h3><br />

   @if ($message = Session::get('error'))
   <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
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

   <form method="post" action="{{ url('/main/darAltaUser') }}">
    {{ csrf_field() }}
    <div class="form-group">
     <label>Usuario</label>
     <input type="email" name="email" class="form-control" />
    </div>
    <div class="form-group">
     <label>Nombre</label>
     <input type="text" name="name" class="form-control" />
    </div>
    <div class="form-group">
     <label>Contraseña</label>
     <input type="password" name="password" class="form-control" />
    </div>
    <div class="form-group">
     <label>Repetir Contraseña</label>
     <input type="password" name="password2" class="form-control" />
    </div>
    <div class="form-group">
     <select class="form-control" name="rol">
         <option selected>Selecciona el tipo perfil:</option>
         <option value="Conductor">Conductor</option>
         <option value="Trabajador">Trabajador</option>
     </select>
    </div>
    <div class="form-group">
       <input type="submit" name="registrar" class="btn btn-primary" value="Registrar" />      
    </div>
     <div class="form-group">
     
    </div>
   </form>
  </div>
 </body>
</html>

