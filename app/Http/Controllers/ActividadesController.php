<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\actividades;
use Response;

class ActividadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>Actividades::all()], 200);
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
        if (!$request->input('nombre') || !$request->input('codigo_monitor')|| !$request->input('informacion'))
		{
			// No estamos recibiendo los campos necesarios. Devolvemos error.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para procesar el alta.'])],422);
        }
        
        // Insertamos los datos recibidos en la tabla.
        $nuevaActividad=actividades::create($request->all());
        
        // Devolvemos la respuesta Http 201 (Created)
		$respuesta= Response::make(json_encode(['data'=>$nuevaActividad]),201);
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

		// Buscamos una actividad por el codigo.
		$actividad=actividades::find($codigo);

		// Si no actividad ese avion devolvemos un error.
		if (!$actividad)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra ninguna actividad con ese código.'])],404);
		}

		return response()->json(['status'=>'ok','data'=>$actividad],200);
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
        
        // Vamos a actualizar una actividad.
		// Comprobamos si la actividad existe. En otro caso devolvemos error.
		$actividad=actividades::find($codigo);

		// Si no existe mostramos error.
		if (! $actividad)
		{
			// Devolvemos error 404.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra ninguna actividad con ese código.'])],404);
		}

		// Almacenamos en variables para facilitar el uso, los campos recibidos.
		$nombre=$request->input('nombre');
		$codigo_monitor=$request->input('codigo_monitor');
		$informacion=$request->input('informacion');

		// Comprobamos si recibimos petición PATCH(parcial) o PUT (Total)
		if ($request->method()=='PATCH')
		{
			$bandera=false;

			// Actualización parcial de datos.
			if ($nombre !=null && $nombre!='')
			{
				$actividad->nombre=$nombre;
				$bandera=true;
			}

			// Actualización parcial de datos.
			if ($codigo_monitor !=null && $codigo_monitor!='')
			{
				$actividad->codigo_monitor=$codigo_monitor;
				$bandera=true;
			}

			// Actualización parcial de datos.
			if ($informacion !=null && $informacion!='')
			{
				$actividad->informacion=$informacion;
				$bandera=true;
			}

			if ($bandera)
			{
				// Grabamos el fabricante.
				$actividad->save();

				// Devolvemos un código 200.
				return response()->json(['status'=>'ok','data'=>$actividad],200);
			}
			else
			{
				// Devolvemos un código 304 Not Modified.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de la actividad.'])],304);
			}
		}


		// Método PUT actualizamos todos los campos.
		// Comprobamos que recibimos todos.
		if (!$nombre || !$codigo_monitor || !$informacion)
		{
			// Se devuelve código 422 Unprocessable Entity.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}

		// Actualizamos los 3 campos:
		$actividad->nombre=$nombre;
		$actividad->codigo_monitor=$codigo_monitor;
		$actividad->informacion=$informacion;

		// Grabamos el fabricante
		$actividad->save();
		return response()->json(['status'=>'ok','data'=>$actividad],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($codigo)
    {
        // Borrado de una Actividad.
		// Comprobamos si la actividad existe o no.
		$actividad=actividades::find($codigo);

		if (! $actividad)
		{
			// Devolvemos error codigo http 404
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra la actividad con ese codigo.'])],404);
		}

		// Borramos la actividad y devolvemos código 204
		// 204 significa "No Content".
		// Este código no muestra texto en el body.
		// Si quisiéramos ver el mensaje devolveríamos
		// un código 200.

		// Eliminamos la actividad.
		$actividad->delete();

		// Se devuelve código 204 No Content.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado correctamente la actividad.'],204);
	}
    
}
