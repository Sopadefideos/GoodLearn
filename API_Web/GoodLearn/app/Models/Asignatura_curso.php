<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura_curso extends Model
{
    use HasFactory;
    public function asignaturas(){
        return $this->hasMany('App\Asignatura');
    }
    public function cursos(){
        return $this->hasMany('App\Curso');
    }
    public $timestamps = false;
}
