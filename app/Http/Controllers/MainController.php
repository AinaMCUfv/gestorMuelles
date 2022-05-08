<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Validator;
use Auth;
use DB;

class MainController extends Controller
{
    function index()
    {
     return view('login')->withOk('--');
    }
    function index2()
    {
     return view('login')->withOk('Registrado correctamente');
    }

    function darAltaUser(Request $request)
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
	     			return redirect('main/1');
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

    function checklogin(Request $request)
    {
	     $this->validate($request, [
		      'email'   => 'required|email',
		      'password'  => 'required|alphaNum|min:3'
	     ]);

	     $user_data = array(
		      'email'  => $request->get('email'),
		      'password' => $request->get('password')
	     );

	     if(Auth::attempt($user_data))
	     {

	     	$results = DB::select('select * from users where email = ?', array($user_data['email']));
	     	$resultArray = json_decode(json_encode($results), true);
	     	//print_r($resultArray);

	     	if($resultArray[0]['rol'] == "Admin"){
				return redirect('main/successlogin');
	     	}else if($resultArray[0]['rol'] == "Conductor"){
				return redirect('main/successconductor');
	     	}else if($resultArray[0]['rol'] == "Trabajador"){
	     		return redirect('main/successtrabajador');
	     	}

	     }
	     else
	     {
	      	return back()->with('error', 'Wrong Login Details');
	     }

    }

    function successlogin()
    {
    	 return view('successlogin');
    }

    function successconductor()
    {
    	 return view('successconductor');
    }

    function successtrabajador()
    {
    	 return view('successtrabajador');
    }

    function logout()
    {
    	Session::flush();
	     Auth::logout();
	     return redirect('/');
    }
    function registro()
    {
	     return view('registro');
    }

   
}
