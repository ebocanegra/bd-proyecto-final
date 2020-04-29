<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\clientes;

use Response;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>Clientes::all()], 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->input('nombre') || !$request->input('nif') || !$request->input('direccion') || !$request->input('correo') ||!$request->input('fechaInscripcion') || !$request->input('tarifa') || !$request->input('contrasena'))
		{
			// No estamos recibiendo los campos necesarios. Devolvemos error.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan datos necesarios para procesar el alta.'])],422);
        }
        
        // Insertamos los datos recibidos en la tabla.
        $nuevoCliente=clientes::create($request->all());
        
        // Devolvemos la respuesta Http 201 (Created)
        $respuesta= Response::make(json_encode(['data'=>$nuevoCliente]),201)->header('Location','http://pi.diiesmurgi.org/~eduardo/public/api/clientes'.$nuevoCliente->id)->header('Content-Type','application/json');
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
        // Buscamos un cliente por el codigo.
		$cliente=clientes::find($codigo);

		// Si no existe ese monitor devolvemos un error.
		if (!$cliente)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra el cliente con ese código.'])],404);
		}

		return response()->json(['status'=>'ok','data'=>$cliente],200);
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
        
         // Vamos a actualizar un cliente.
		// Comprobamos si la clientes existe. En otro caso devolvemos error.
		$clientes=clientes::find($codigo);

		// Si no existe mostramos error.
		if (! $clientes)
		{
			// Devolvemos error 404.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra ningun cliente con ese código.'])],404);
		}

		// Almacenamos en variables para facilitar el uso, los campos recibidos.
		$nombre=$request->input('nombre');
		$nif=$request->input('nif');
        $direccion=$request->input('direccion');
        $correo=$request->input('correo');
        $fechaInscripcion=$request->input('fechaInscripcion');
        $tarifa=$request->input('tarifa');
        $contrasena=$request->input('contrasena');

		// Comprobamos si recibimos petición PATCH(parcial) o PUT (Total)
		if ($request->method()=='PATCH')
		{
			$bandera=false;

			// Actualización parcial de datos.
			if ($nombre !=null && $nombre!='')
			{
				$clientes->nombre=$nombre;
				$bandera=true;
			}

			// Actualización parcial de datos.
			if ($nif !=null && $nif!='')
			{
				$clientes->nif=$nif;
				$bandera=true;
			}

			// Actualización parcial de datos.
			if ($direccion !=null && $direccion!='')
			{
				$clientes->direccion=$direccion;
				$bandera=true;
            }
            // Actualización parcial de datos.
            if ($correo !=null && $correo!='')
			{
				$clientes->direccion=$correo;
				$bandera=true;
            }
            // Actualización parcial de datos.
            if ($fechaInscripcion !=null && $fechaInscripcion!='')
			{
				$clientes->fechaInscripcion=$fechaInscripcion;
				$bandera=true;
            }
            // Actualización parcial de datos.
            if ($tarifa !=null && $tarifa!='')
			{
				$clientes->tarifa=$tarifa;
				$bandera=true;
            }
            // Actualización parcial de datos.
            if ($contrasena !=null && $contrasena!='')
			{
				$clientes->contrasena=$contrasena;
				$bandera=true;
			}

			if ($bandera)
			{
				// Grabamos el fabricante.
				$clientes->save();

				// Devolvemos un código 200.
				return response()->json(['status'=>'ok','data'=>$clientes],200);
			}
			else
			{
				// Devolvemos un código 304 Not Modified.
				return response()->json(['errors'=>array(['code'=>304,'message'=>'No se ha modificado ningún dato de la actividad.'])],304);
			}
		}


		// Método PUT actualizamos todos los campos.
		// Comprobamos que recibimos todos.
		if (!$nombre || !$nif || !$direccion || !$correo || !$fechaInscripcion || !$tarifa || !$contrasena)
		{
			// Se devuelve código 422 Unprocessable Entity.
			return response()->json(['errors'=>array(['code'=>422,'message'=>'Faltan valores para completar el procesamiento.'])],422);
		}

		// Actualizamos los 3 campos:
		$clientes->nombre=$nombre;
		$clientes->nif=$nif;
        $clientes->direccion=$direccion;
        $clientes->correo=$correo;
        $clientes->fechaInscripcion=$fechaInscripcion;
        $clientes->tarifa=$tarifa;
        $clientes->contrasena=$contrasena;

		// Grabamos el fabricante
		$clientes->save();
		return response()->json(['status'=>'ok','data'=>$clientes],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($codigo)
    {
        // Comprobamos si el cliente existe o no.
		$cliente=clientes::find($codigo);

		if (! $cliente)
		{
			// Devolvemos error codigo http 404
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra el cliente con ese codigo.'])],404);
		}

		// Borramos el monitor y devolvemos código 204
		// 204 significa "No Content".
		// Este código no muestra texto en el body.
		// Si quisiéramos ver el mensaje devolveríamos
		// un código 200.

		// Eliminamos la actividad.
		$cliente->delete();

		// Se devuelve código 204 No Content.
		return response()->json(['code'=>204,'message'=>'Se ha eliminado correctamente el cliente.'],204);
    }
}
