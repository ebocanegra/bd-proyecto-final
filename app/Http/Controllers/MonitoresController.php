<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\monitores;

class MonitoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','filasTotales'=>Monitores::get()->count(), 'data'=>Monitores::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->input('nombre') || !$request->input('nif') || !$request->input('direccion') || !$request->input('correo') ||!$request->input('telefono') || !$request->input('contrasena'))
		{
			// No estamos recibiendo los campos necesarios. Devolvemos error.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para procesar el alta.'])],422);
        }
        
        // Insertamos los datos recibidos en la tabla.
        $nuevoMonitor=monitores::create($request->all());
        
        // Devolvemos la respuesta Http 201 (Created)
        $respuesta= Response::make(json_encode(['data'=>$nuevoMonitor]),201)->header('Location','http://pi.diiesmurgi.org/~eduardo/public/api/monitores'.$nuevoMonitor->id)->header('Content-Type','application/json');
		return $respuesta;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($codigo)
    {

		// Buscamos un monitor por el codigo.
		$monitor=monitores::find($codigo);

		// Si no existe ese monitor devolvemos un error.
		if (!$monitor)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra el monitor con ese código.'])],404);
		}

		return response()->json(['status'=>'ok','data'=>$monitor],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $codigo)
    {
         // Vamos a actualizar un monitor.
		// Comprobamos si el monitor existe. En otro caso devolvemos error.
		$monitores=monitores::find($codigo);

		// Si no existe mostramos error.
		if (! $monitores)
		{
			// Devolvemos error 404.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra ningun monitor con ese código.'])],404);
		}

		// Almacenamos en variables para facilitar el uso, los campos recibidos.
		$nombre=$request->input('nombre');
		$nif=$request->input('nif');
        $direccion=$request->input('direccion');
        $correo=$request->input('correo');
        $telefono=$request->input('telefono');
        $contrasena=$request->input('contrasena');

		// Comprobamos si recibimos petición PATCH(parcial) o PUT (Total)
		if ($request->method()=='PATCH')
		{
			$bandera=false;

			// Actualización parcial de datos.
			if ($nombre !=null && $nombre!='')
			{
				$monitores->nombre=$nombre;
				$bandera=true;
			}

			// Actualización parcial de datos.
			if ($nif !=null && $nif!='')
			{
				$monitores->nif=$nif;
				$bandera=true;
			}

			// Actualización parcial de datos.
			if ($direccion !=null && $direccion!='')
			{
				$monitores->direccion=$direccion;
				$bandera=true;
            }
            // Actualización parcial de datos.
            if ($correo !=null && $correo!='')
			{
				$monitores->direccion=$correo;
				$bandera=true;
            }
            // Actualización parcial de datos.
            if ($telefono !=null && $telefono!='')
			{
				$monitores->telefono=$telefono;
				$bandera=true;
            }
            // Actualización parcial de datos.
            if ($contrasena !=null && $contrasena!='')
			{
				$monitores->contrasena=$contrasena;
				$bandera=true;
			}

			if ($bandera)
			{
				// Grabamos el fabricante.
				$monitores->save();

				// Devolvemos un código 200.
				return response()->json(['status'=>'ok','data'=>$monitores],200);
			}
			else
			{
				// Devolvemos un código 304 Not Modified.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de la actividad.'])],304);
			}
		}


		// Método PUT actualizamos todos los campos.
		// Comprobamos que recibimos todos.
		if (!$nombre || !$nif || !$direccion || !$correo || !$telefono || !$contrasena)
		{
			// Se devuelve código 422 Unprocessable Entity.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}

		// Actualizamos los 3 campos:
		$monitores->nombre=$nombre;
		$monitores->nif=$nif;
        $monitores->direccion=$direccion;
        $monitores->correo=$correo;
        $monitores->telefono=$telefono;
        $monitores->contrasena=$contrasena;

		// Grabamos el fabricante
		$monitores->save();
		return response()->json(['status'=>'ok','data'=>$monitores],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($codigo)
    {
        // Comprobamos si el monitor existe o no.
		$monitor=monitores::find($codigo);

		if (! $monitor)
		{
			// Devolvemos error codigo http 404
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra el monitor con ese codigo.'])],404);
		}

		// Borramos el monitor y devolvemos código 204
		// 204 significa "No Content".
		// Este código no muestra texto en el body.
		// Si quisiéramos ver el mensaje devolveríamos
		// un código 200.

		// Eliminamos la actividad.
		$monitor->delete();

		// Se devuelve código 204 No Content.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado correctamente el monitor.'],204);
    }
}
