<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    //
    protected $table = 't_alumnos';

    protected $primaryKey = 'id_t_usuario';

    protected $fillable = [
        'nombre',
        'ap_paterno',
    	'ap_materno',
    	'activo',
    ];

    public $timestamps = false;     

    public function calificacion(){
        return $this->hasMany('App\Calificaciones', 'id_t_usuario');
    }     
}
