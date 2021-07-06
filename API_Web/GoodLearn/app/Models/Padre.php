<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    use HasFactory;
    public function padre(){
        return $this->hasMany('App\Usuario');
    }
    public function alumno(){
        return $this->hasMany('App\Usuario');
    }
    public $timestamps = false;
}
