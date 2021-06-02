<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_creacion',
        'fecha_lectura',
        'estado',
    ];
    public function usuarios(){
        return $this->hasMany('App\Usuario');
    }
    public function tipo_notifiacions(){
        return $this->hasMany('App\Tipo_notificacion');
    }
    public $timestamps = false;
}
