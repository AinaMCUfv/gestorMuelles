<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservaRequest;
use App\Http\Requests\UpdateReservaRequest;
use DB;

class ReservasController extends Controller
{
    /**
     * Display all Reservas
     * 
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        //$Reservas = Reserva::latest()->paginate(10);
        if(Auth::user()->rol == "Admin"){
            $reservas = DB::select('select * from reservas');
        }else if(Auth::user()->rol == "Trabajador"){
            $reservas = DB::select('select * from reservas where cancelada=0');
        }else{
            $reservas = DB::select('select * from reservas where cancelada=0 and idUsuario=?', array(Auth::user()->id));
        }
        
        //$resultArray = json_decode(json_encode($reservas), true);
        //print_r($reservas);


        return view('Reservas.index', compact('reservas'));
    }


    public function create() 
    {
        return view('reservas.create');
    }

    function darAltaReserva(Request $request)
    {
         $this->validate($request, [
              'codigo'   => 'required|min:6',
              'tipo'   => 'required',
              'carga'  => 'required|alphaNum',
              'fecha'  => 'required'
         ]);


        $data = array(
              'codigo'  => $request->get('codigo'),
              'tipo'  => $request->get('tipo'),
              'carga' => $request->get('carga'),
              'fecha' => $request->get('fecha')
         );

        $tomorrowMidnight = mktime($data['fecha'], 0, 0, date('n'), date('j') + 1);
        $fecha_final = date('y-m-j H:i', $tomorrowMidnight);//Apr 26 2022 6:00 PM
        //print($fecha_final);//2022-04-24 00:00:00


        $results = DB::insert('insert into reservas (numpedido, tipov, carga, idUsuario, fecha, cancelada) values (?, ?, ?, ?, ?, ?)', [$data['codigo'], $data['tipo'],$data['carga'],Auth::user()->id,$fecha_final,0]);

        if($results ==1){
            return redirect('reservas/');
        }
       
        
    }

    function destroy(Reserva $reserva)
    {
        DB::update('update reservas set cancelada =1 where id = ?', array($reserva->id));
        
        return redirect()->route('reservas.index')->withSuccess(__('Reserva borrada correctamente.'));

    }

    function edit(Reserva $reserva) 
    {
        return view('reservas.edit', ['reserva' => $reserva]);
    }

    function update(Reserva $reserva, Request $request) 
    {
         $this->validate($request, [
              'fecha'  => 'required'
         ]);

        $tomorrowMidnight = mktime($request->get('fecha'), 0, 0, date('n'), date('j') + 1);
        $fecha_final = date('y-m-j H:i', $tomorrowMidnight);//Apr 26 2022 6:00 PM


         DB::update('update reservas set fecha =? where id = ?', array($fecha_final,$reserva->id));

        return redirect()->route('reservas.index')->withSuccess(__('Reserva modificada correctamente.'));
    }

   
}