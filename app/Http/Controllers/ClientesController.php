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
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
