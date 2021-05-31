<?php

namespace App\Http\Controllers;
use App\Models\{Usuario, Rol};

function prettyUser($users){
    $data = $users;
    foreach($data as $user){
        $rol_id = $user->rol_id;
        $rol = Rol::find($rol_id);
        $user->rol_id = $rol;
    }
    return $data;
}