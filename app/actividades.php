<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class actividades extends Model
{
     // Nombre de la tabla en MySQL.
	protected $table="actividades";

    protected $primaryKey = 'codigo';

	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('nombre', 'codigo_monitor', 'informacion');
	
	// Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	protected $hidden = ['created_at','updated_at']; 

}
