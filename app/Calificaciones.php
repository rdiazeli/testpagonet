<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Calificaciones extends Model
{
    //
    protected $table = 't_calificaciones';

    protected $primaryKey = 'id_t_calificacion';

    protected $fillable = [
        'id_t_materia',
        'id_t_usuario',
        'calificacion',
        'fecha_registro',
    ];


    public $timestamps = false;    

    public function alumnocalificacion(){
        return $this->belongsTo('App\Alumnos', 'id_t_usuario');
    }

    public function materiacalificacion(){
        return $this->belongsTo('App\Materias', 'id_t_materia');
    }
}