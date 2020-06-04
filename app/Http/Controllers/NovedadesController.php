<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Novedades;
use Response;

class NovedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','filasTotales'=>Novedades::get()->count(), 'data'=>Novedades::all()], 200);
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
        if (!$request->input('titulo') || !$request->input('contenido')|| !$request->input('fecha')|| !$request->input('codigo_monitor'))
		{
			// No estamos recibiendo los campos necesarios. Devolvemos error.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para procesar el alta.'])],422);
        }
        
        // Insertamos los datos recibidos en la tabla.
        $nuevaNovedad=Novedades::create($request->all());
        
        // Devolvemos la respuesta Http 201 (Created)
		$respuesta= Response::make(json_encode(['data'=>$nuevaNovedad]),201);
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
		$novedad=Novedades::find($codigo);

		// Si no actividad ese avion devolvemos un error.
		if (!$novedad)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra ninguna actividad con ese código.'])],404);
		}

		return response()->json(['status'=>'ok','data'=>$novedad],200);
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
		$novedad=Novedades::find($codigo);

		// Si no existe mostramos error.
		if (! $novedad)
		{
			// Devolvemos error 404.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra ninguna novedad con ese código.'])],404);
		}

		// Almacenamos en variables para facilitar el uso, los campos recibidos.
        $titulo=$request->input('titulo');
		$contenido=$request->input('contenido');
		$fecha=$request->input('fecha');
		$codigo_monitor=$request->input('codigo_monitor');
		

		// Comprobamos si recibimos petición PATCH(parcial) o PUT (Total)
		if ($request->method()=='PATCH')
		{
			$bandera=false;

			// Actualización parcial de datos.
			if ($titulo !=null && $titulo!='')
			{
				$novedad->titulo=$titulo;
				$bandera=true;
			}

			if ($fecha !=null && $fecha!='')
			{
				$novedad->fecha=$fecha;
				$bandera=true;
			}

			// Actualización parcial de datos.
			if ($codigo_monitor !=null && $codigo_monitor!='')
			{
				$novedad->codigo_monitor=$codigo_monitor;
				$bandera=true;
			}

			// Actualización parcial de datos.
			if ($contenido !=null && $contenido!='')
			{
				$novedad->contenido=$contenido;
				$bandera=true;
			}

			if ($bandera)
			{
				// Grabamos el fabricante.
				$novedad->save();

				// Devolvemos un código 200.
				return response()->json(['status'=>'ok','data'=>$novedad],200);
			}
			else
			{
				// Devolvemos un código 304 Not Modified.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de la Novedad.'])],304);
			}
		}


		// Método PUT actualizamos todos los campos.
		// Comprobamos que recibimos todos.
		if (!$titulo || !$codigo_monitor || !$fecha || !$contenido)
		{
			// Se devuelve código 422 Unprocessable Entity.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}

		// Actualizamos los 3 campos:
		$novedad->titulo=$titulo;
		$novedad->fecha=$fecha;
		$novedad->codigo_monitor=$codigo_monitor;
		$novedad->contenido=$contenido;

		// Grabamos el fabricante
		$novedad->save();
		return response()->json(['status'=>'ok','data'=>$novedad],200);



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
		$novedad=Novedades::find($codigo);

		if (! $novedad)
		{
			// Devolvemos error codigo http 404
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra ninguna novedad con ese codigo.'])],404);
		}

		// Borramos la actividad y devolvemos código 204
		// 204 significa "No Content".
		// Este código no muestra texto en el body.
		// Si quisiéramos ver el mensaje devolveríamos
		// un código 200.

		// Eliminamos la actividad.
		$novedad->delete();

		// Se devuelve código 204 No Content.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado correctamente la novedad.'],204);
    }
}
