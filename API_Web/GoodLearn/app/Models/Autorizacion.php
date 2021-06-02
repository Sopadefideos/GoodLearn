<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'url_autorizacion',
        'estado',
        'fecha_creacion',
        'fecha_modificacion',
    ];
    public function asignaturas(){
        return $this->hasMany('App\Asignatura');
    }
    public function usuarios(){
        return $this->hasMany('App\Usuario');
    }
    public $timestamps = false;
}
