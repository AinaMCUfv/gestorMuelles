<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservaRequest;
use App\Http\Requests\UpdateReservaRequest;
use DB;

class UsuariosController extends Controller
{
    /**
     * Display all Usuarios
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $usuarios = DB::select('select * from users');     
        //$resultArray = json_decode(json_encode($usuarios), true);
        //print_r($usuarios);
        return view('Usuarios.index', compact('usuarios'));
    }


    public function create() 
    {
        return view('usuarios.create');
    }

    function darAltaUsuario(Request $request)
    {
         $this->validate($request, [
              'email'   => 'required|email',
              'name'   => 'required|alphaNum|min:3',
              'password'  => 'required|alphaNum|min:3',
              'password2'  => 'required|alphaNum|min:3',
              'rol' => 'required'
         ]);


        $user_data = array(
              'email'  => $request->get('email'),
              'name'  => $request->get('name'),
              'password' => $request->get('password'),
              'password2' => $request->get('password2'),
              'rol' => $request->get('rol')
         );

        if($user_data['password'] == $user_data['password2']){
            $results = DB::select('select count(*) as total from users where email = ?', array($user_data['email']));
            $resultArray = json_decode(json_encode($results), true);
            if($resultArray[0]['total'] == 0){

                $results = DB::insert('insert into users (email, name,password,rol) values (?, ?,?,?)', [$user_data['email'], $user_data['name'],Hash::make($user_data['password']),$user_data['rol']]);

                if($results ==1){
                    return redirect('usuarios/');
                }
            }
            else
            {
                return back()->with('error', 'Cuenta ya existe');
            }
        }
        else
        {
            return back()->with('error', 'La contraseña no coincide');
        }
       
        
    }

    function destroy(User $usuario)
    {
        DB::update('update users set borrado =1 where id = ?', array($usuario->id));
        return redirect()->route('usuarios.index')->withSuccess(__('Usuario dado de baja correctamente.'));

    }

    function edit(Reserva $reserva) 
    {
        return view('usuarios.edit', ['reserva' => $reserva]);
    }

    function update(Reserva $reserva, Request $request) 
    {
         $this->validate($request, [
              'fecha'  => 'required'
         ]);

        $tomorrowMidnight = mktime($request->get('fecha'), 0, 0, date('n'), date('j') + 1);
        $fecha_final = date('y-m-j H:i', $tomorrowMidnight);//Apr 26 2022 6:00 PM


         DB::update('update usuarios set fecha =? where id = ?', array($fecha_final,$reserva->id));

        return redirect()->route('usuarios.index')->withSuccess(__('Reserva modificada correctamente.'));
    }

   
}