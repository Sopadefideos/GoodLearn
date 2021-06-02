<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumnos_curso extends Model
{
    use HasFactory;
    public function usuarios(){
        return $this->hasMany('App\Usuario');
    }
    public function cursos(){
        return $this->hasMany('App\Curso');
    }
    public $timestamps = false;
}
