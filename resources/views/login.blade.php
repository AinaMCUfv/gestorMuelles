<!DOCTYPE html>
<html>
 <head>
  <title>Bienvevidos al gestor de Muelles DHL</title>
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
   <h3 align="center">Bienvevidos al gestor de Muelles DHL</h3><br />

   <!--@if(isset(Auth::user()->email))
    <script>window.location="/main/successlogin";</script>
   @endif-->

   @if ($message = Session::get('error'))
   <div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
   </div>
   @endif

   @if( $ok != " ")
   <div class="alert alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <strong>{{$ok}}</strong>
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


   <form method="post" action="{{ url('/main/checklogin') }}">
    {{ csrf_field() }}
    <div class="form-group">
     <label>Usuario</label>
     <input type="email" name="email" class="form-control" />
    </div>
    <div class="form-group">
     <label>Contraseña</label>
     <input type="password" name="password" class="form-control" />
    </div>
    <div class="form-group">
       <input type="submit" name="login" class="btn btn-primary" value="Login" />
       <button type="button" class="btn btn-primary" onclick="window.location='{{ url("main/registro") }}'">Registrar</button>
    </div>
     <div class="form-group">
     
    </div>
   </form>
  </div>
 </body>
</html>