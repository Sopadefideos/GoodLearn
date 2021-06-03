<?php

namespace App\Http\Controllers;
use App\Models\{Usuario, Rol,
     Publicacion, Tipo_notificacion, 
     Curso, Asignatura, Asignatura_curso,
     Asistencia};

function prettyUser($users){
    $data = $users;
    try {
        foreach($data as $user){
            $rol_id = $user->rol_id;
            $rol = Rol::find($rol_id);
            $user->rol_id = $rol;
        }
    } catch (\Exception $e) {
        $rol_id = $data->rol_id;
        $rol = Rol::find($rol_id);
        $data->rol_id = $rol;
    }
    return $data;
}

function prettyPublicacion($publicacion){
    $data = $publicacion;
    try {
        foreach($data as $usuario){
            $usuario_id = $usuario->usuario_id;
            $user = Usuario::find($usuario_id);
            $full_user = prettyUser($user);
            $usuario->usuario_id = $full_user;
        }
    } catch (\Exception $e) {
        $usuario_id = $data->usuario_id;
        $user = Usuario::find($usuario_id);
        $full_user = prettyUser($user);
        $data->usuario_id = $full_user;
    }
    return $data;
}

function prettyNotificacion($notificacion){
    $data = $notificacion;
    try{
        foreach($data as $noti){
            $usuario_id = $noti->usuario_id;
            $user = Usuario::find($usuario_id);
            $full_user = prettyUser($user);
            $noti->usuario_id = $full_user;
            $tipo = Tipo_notificacion::find($noti->tipo_id);
            $noti->tipo_id = $tipo;
        }
    } catch (\Exception $e) {
        $usuario_id = $data->usuario_id;
        $user = Usuario::find($usuario_id);
        $full_user = prettyUser($user);
        $data->usuario_id = $full_user;
        $tipo = Tipo_notificacion::find($data->tipo_id);
        $data->tipo_id = $tipo;
    }
    return $data;
}

function prettyAlumno_curso($alumno_curso){
    $data = $alumno_curso;
    try{
        foreach($data as $alum_curso){
            $user = Usuario::find($alum_curso->usuario_id);
            $pretty_user = prettyUser($user);
            $alum_curso->usuario_id = $pretty_user;
            $curso = Curso::find($alum_curso->curso_id);
            $alum_curso->curso_id = $curso;
        }
    } catch (\Exception $e) {
        $user = Usuario::find($data->usuario_id);
        $pretty_user = prettyUser($user);
        $data->usuario_id = $pretty_user;
        $curso = Curso::find($data->curso_id);
        $data->curso_id = $curso;
    }

    return $data;
}


function prettyAsignatura($asignatura){
    $data = $asignatura;
    try{
        foreach($data as $asig){
            $user = Usuario::find($asig->usuario_id);
            $pretty_user = prettyUser($user);
            $asig->usuario_id = $pretty_user;
        }
    } catch (\Exception $e) {
        $user = Usuario::find($data->usuario_id);
        $pretty_user = prettyUser($user);
        $data->usuario_id = $pretty_user;
    }

    return $data;
}

function prettyAsignatura_Curso($asignatura_curso){
    $data = $asignatura_curso;
    try{
        foreach($data as $asig_curso){
            $curso = Curso::find($asig_curso->curso_id);
            $asig_curso->curso_id = $curso;
            $asignatura = Asignatura::find($asig_curso->asignatura_id);
            $pretty_asignatura = prettyAsignatura($asignatura);
            $asig_curso->asignatura_id = $pretty_asignatura;
        }
    } catch (\Exception $e) {
        $curso = Curso::find($data->curso_id);
        $data->curso_id = $curso;
        $asignatura = Asignatura::find($data->asignatura_id);
        $pretty_asignatura = prettyAsignatura($asignatura);
        $data->asignatura_id = $pretty_asignatura;
    }
    return $data;
}

function prettyAsistencia($asistencias){
    $data = $asistencias;
    try{
        foreach($asistencias as $asist){
            $asignatura = Asignatura::find($asist->asignatura_id);
            $pretty_asignatura = prettyAsignatura($asignatura);
            $user = Usuario::find($asig->usuario_id);
            $pretty_user = prettyUser($user);
            $asist->asignatura_id = $pretty_asignatura;
            $asist->usuario_id = $pretty_user;
        }
    } catch (\Exception $e) {
        $asignatura = Asignatura::find($data->asignatura_id);
        $pretty_asignatura = prettyAsignatura($asignatura);
        $user = Usuario::find($data->usuario_id);
        $pretty_user = prettyUser($user);
        $data->asignatura_id = $pretty_asignatura;
        $data->usuario_id = $pretty_user;
    }
}