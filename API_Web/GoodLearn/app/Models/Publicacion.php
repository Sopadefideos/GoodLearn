<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'url_img',
        'fecha_creacion',
        'fecha_modificacion',
    ];
    public function usuarios(){
        return $this->hasMany('App\Usuario');
    }

    public $timestamps = false;
}
