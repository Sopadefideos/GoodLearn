<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario_publicacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'comentario',
        'fecha_creacion',
        'fecha_modificacion',
    ];
    public function publicacions(){
        return $this->hasMany('App\Publicacion');
    }
    public function usuarios(){
        return $this->hasMany('App\Usuario');
    }
    public $timestamps = false;
}
