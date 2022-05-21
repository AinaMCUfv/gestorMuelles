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
            $reservas = DB::select('select * from reservas where cancelada=0 and (now()- INTERVAL 10 MINUTE < fecha)');
            // and now()+ INTERVAL 10 MINUTE > fecha
        }else{
            $reservas = DB::select('select * from reservas where cancelada=0 and idUsuario=? 
                and (now()- INTERVAL 10 MINUTE < fecha )', array(Auth::user()->id));
        }
        
        //$resultArray = json_decode(json_encode($reservas), true);
        //print_r($reservas);


        return view('Reservas.index', compact('reservas'));
    }


    public function create() 
    {
        return view('reservas.create');
    }

    public function historico() 
    {
        $reservas = DB::select('select * from reservas where idUsuario=?', array(Auth::user()->id));

        return view('reservas.historico', compact('reservas'));
    }

    function darAltaReserva(Request $request)
    {
         $this->validate($request, [
              'codigo'   => 'required|min:6',
              'tipo'   => 'required',
              'matricula' => 'required|min:7|max:7',
              'carga'  => 'required|alphaNum',
              'fecha'  => 'required'
         ]);


        $data = array(
              'codigo'  => $request->get('codigo'),
              'tipo'  => $request->get('tipo'),
              'carga' => $request->get('carga'),
              'matricula'  => $request->get('matricula'),
              'fecha' => $request->get('fecha')
         );

        $tomorrowMidnight = mktime($data['fecha'], 0, 0, date('n'), date('j') + 1);
        $fecha_final = date('y-m-j H:i', $tomorrowMidnight);//Apr 26 2022 6:00 PM
        //print($fecha_final);//2022-04-24 00:00:00


        //chequear si ya existe reserva en esa hora y dia
        $reservas = DB::select('select * from reservas where fecha = ? and matricula=?', array($fecha_final,$data['matricula']));
      
          if(count($reservas) == 0){
            $results = DB::insert('insert into reservas (numpedido, tipov, carga, idUsuario, fecha, cancelada,matricula) values (?, ?, ?, ?, ?, ?,?)', [$data['codigo'], $data['tipo'],$data['carga'],Auth::user()->id,$fecha_final,0,$data['matricula']] );

            if($results ==1){
                return redirect('reservas/');
            }
          }else{
             return back()->with('error', 'Reserva para esa hora y dia ya existe');
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

    function matriculas() 
    {
        return view('matriculas.index');
    }

     function check(Request $request)
    {
         $this->validate($request, [
              'matricula'   => 'required|min:7|max:7'
         ]);


        $data = array(
              'matricula'  => $request->get('matricula')
         );

        //print_r($fecha_final);die;
        $reservas = DB::select('select * from reservas where matricula=? and entrada = 1', array($data['matricula']));
        if(count($reservas) > 0){


        }else{
            $reservas = DB::select('select * from reservas where (fecha + INTERVAL 10 MINUTE > now() and fecha - INTERVAL 10 MINUTE < now()) and matricula=?', array($data['matricula']));
        }

         
      
          if(count($reservas) > 0){
                $resultArray = json_decode(json_encode($reservas), true);
                //print_r($resultArray[0]['entrada']);die;
                if($resultArray[0]['entrada'] == 0){//esta entrando

                    DB::update('update reservas set entrada = 1 where id = ?', array($resultArray[0]['id']));

                    return back()->with('success', 'Entrada de mercancia a la hora correcta, Levantando barrera...');
                }else if($resultArray[0]['entrada'] == 1){//esta saliendo
                    date_default_timezone_set('Europe/Madrid');
                    $date1 = now();
                    $date2 =  $resultArray[0]['fecha'];
                    $tiempo =  $date1->diff($date2);//tiempo de la carga o descarga
                    //print_r($tiempo->i);die;

                    DB::update('update reservas set entrada = 2 where id = ?', array($resultArray[0]['id']));

                    //chequeo de si esta saliendo en su hora correcta
                    if($resultArray[0]['tipov'] == 'Furgoneta'){
                        if($resultArray[0]['carga'] == 0){//20'
                            if($tiempo->i <= 20){
                               return back()->with('success', 'Salida de mercancia a la hora correcta, Levantando barrera...'); 
                            }else{
                                return back()->with('error', 'Salida de mercancia fuera del horario, Levantando barrera...');
                            }
                        }else{//15'
                            if($tiempo <= 15){
                               return back()->with('success', 'Salida de mercancia a la hora correcta, Levantando barrera...'); 
                            }else{
                                return back()->with('error', 'Salida de mercancia fuera del horario, Levantando barrera...');
                            }
                        }

                    }else if($resultArray[0]['tipov'] == 'Trailer'){
                        if($resultArray[0]['carga'] == 0){//60'
                            if($tiempo->i <= 60){
                               return back()->with('success', 'Salida de mercancia a la hora correcta, Levantando barrera...'); 
                            }else{
                                return back()->with('error', 'Salida de mercancia fuera del horario, Levantando barrera...');
                            }
                        }else{//45'
                            if($tiempo->i <= 45){
                               return back()->with('success', 'Salida de mercancia a la hora correcta, Levantando barrera...'); 
                            }else{
                                return back()->with('error', 'Salida de mercancia fuera del horario, Levantando barrera...');
                            }
                        }
                        
                    }else if($resultArray[0]['tipov'] == 'Lona'){
                        if($resultArray[0]['carga'] == 0){//40'
                            if($tiempo->i <= 40){
                               return back()->with('success', 'Salida de mercancia a la hora correcta, Levantando barrera...'); 
                            }else{
                                return back()->with('error', 'Salida de mercancia fuera del horario, Levantando barrera...');
                            }
                        }else{//30'
                            if($tiempo->i <= 30){
                               return back()->with('success', 'Salida de mercancia a la hora correcta, Levantando barrera...'); 
                            }else{
                                return back()->with('error', 'Salida de mercancia fuera del horario, Levantando barrera...');
                            }
                        }
                        
                    }




                }else if($resultArray[0]['entrada'] == 2){
                    return back()->with('success', 'Este camion ya realizo su entrada y salida'); 

                }




            
          }else{
             return back()->with('error', 'No se levanta la barrera');
          }
       


    }

   
}