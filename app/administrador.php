<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class administrador extends Model
{
    // Nombre de la tabla en MySQL.
	protected $table="administrador";

    protected $primaryKey = 'nombre';

	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('nombre','contrasena');
 
	
}
