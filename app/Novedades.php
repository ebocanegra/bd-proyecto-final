<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Novedades extends Model
{
    protected $table="novedades";

	protected $primaryKey = 'codigo';
	

	// Atributos que se pueden asignar de manera masiva.
	protected $fillable = array('titulo', 'fecha', 'codigo_monitor', 'contenido');
	
	// Aquí ponemos los campos que no queremos que se devuelvan en las consultas.
	protected $hidden = ['created_at','updated_at']; 
}
