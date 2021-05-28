<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;
    protected $fillable = [
        'nota',
        'fecha_creacion',
        'fecha_modificacion',
        'titulo',
        'cuerpo',
    ];
    public function asignaturas(){
        return $this->hasMany('App\Usuario');
    }
    public function usuarios(){
        return $this->hasMany('App\Usuario');
    }
    public $timestamps = false;
}
