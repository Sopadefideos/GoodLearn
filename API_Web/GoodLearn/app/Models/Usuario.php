<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'telefono',
        'direccion',
        'password',
    ];

    public function rol(){
        return $this->belongsTo('App\Models\Rol', 'rol_id', 'id');
    }
    protected $table = 'usuario';
    public $timestamps = false;
}
