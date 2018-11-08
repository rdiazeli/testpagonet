<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materias extends Model
{
    //

    protected $table = 't_materias';
    protected $primaryKey = 'id_t_materia';
    protected $fillable = [
        'nombre',
        'activo',
    ];

    public $timestamps = false;

    public function calificacion(){
        return $this->hasMany('App\Calificaciones', 'id_t_materia');
    }    
}