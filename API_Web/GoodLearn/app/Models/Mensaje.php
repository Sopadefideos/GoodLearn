<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;
    protected $fillable = [
        'texto',
        'fecha_creacion',
        'fecha_modificacion',
        'estado',
    ];
    public function emisor(){
        return $this->hasMany('App\Usuario', 'emisor_id');
    }
    public function receptor(){
        return $this->hasMany('App\Usuario', 'receptor_id');
    }
    public $timestamps = false;
}
