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

    function edit(User $usuario) 
    {
        return view('usuarios.edit', ['usuario' => $usuario]);
    }

    function update(User $usuario, Request $request) 
    {
         $this->validate($request, [
              'password'  => 'required|alphaNum|min:3',
              'password2'  => 'required|alphaNum|min:3',
         ]);


         DB::update('update users set password =? where id = ?', array(Hash::make($request->get('password')),$usuario->id));

        return redirect()->route('usuarios.index')->withSuccess(__('Contraseña modificada correctamente.'));
    }

   
}