<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
     // Nombre de la tabla en MySQL.
	protected $table="clientes";

    protected $primaryKey = 'codigo';

	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('codigo', 'nombre', 'nif', 'direccion', 'correo', 'fechaInscripcion', 'tarifa', 'contrasena' );
	
	// Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	protected $hidden = ['created_at','updated_at'];
}
