<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class monitores extends Model
{
    // Nombre de la tabla en MySQL.
	protected $table="monitores";

    protected $primaryKey = 'codigo';

	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('nombre', 'nif', 'direccion', 'correo', 'telefono', 'contrasena' );
	
	// Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	protected $hidden = ['created_at','updated_at']; 

}
