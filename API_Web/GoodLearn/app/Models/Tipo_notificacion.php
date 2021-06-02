<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_notificacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_tipo',
        'titulo',
        'cuerpo',
    ];
    public $timestamps = false;
}
