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
        foreach($data as $asist){
            $asignatura = Asignatura::find($asist->asignatura_id);
            $pretty_asignatura = prettyAsignatura($asignatura);
            $user = Usuario::find($asist->usuario_id);
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

    return $data;
}

function prettyAutorizacion($autorizaciones){
    $data = $autorizaciones;
    try{
        foreach($autorizaciones as $asist){
            $asignatura = Asignatura::find($asist->asignatura_id);
            $pretty_asignatura = prettyAsignatura($asignatura);
            $user = Usuario::find($asist->usuario_id);
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

    return $data;
}


function prettyContenido($contenidos){
    $data = $contenidos;
    try{
        foreach($contenidos as $contenido){
            $asignatura = Asignatura::find($contenido->asignatura_id);
            $pretty_asignatura = prettyAsignatura($asignatura);
            $contenido->asignatura_id = $pretty_asignatura;
        }
    } catch (\Exception $e) {
        $asignatura = Asignatura::find($data->asignatura_id);
        $pretty_asignatura = prettyAsignatura($asignatura);
        $data->asignatura_id = $pretty_asignatura;
    }

    return $data;
}

function prettyNota($notas){
    $data = $notas;
    try{
        foreach($notas as $nota){
            $asignatura = Asignatura::find($nota->asignatura_id);
            $pretty_asignatura = prettyAsignatura($asignatura);
            $user = Usuario::find($nota->usuario_id);
            $pretty_user = prettyUser($user);
            $nota->asignatura_id = $pretty_asignatura;
            $nota->usuario_id = $pretty_user;
        }
    } catch (\Exception $e) {
        $asignatura = Asignatura::find($data->asignatura_id);
        $pretty_asignatura = prettyAsignatura($asignatura);
        $user = Usuario::find($data->usuario_id);
        $pretty_user = prettyUser($user);
        $data->asignatura_id = $pretty_asignatura;
        $data->usuario_id = $pretty_user;
    }

    return $data;
}

function prettyComentarioPublicacion($comentariosPublicacion){
    $data = $comentariosPublicacion;
    try{
        foreach($comentariosPublicacion as $comentario){
            $user = Usuario::find($comentario->usuario_id);
            $pretty_user = prettyUser($user);
            $publicacion = Publicacion::find($comentario->publicacion_id);
            $pretty_publicacion = prettyPublicacion($publicacion);
            $comentario->usuario_id = $pretty_user;
            $comentario->publicacion_id = $pretty_publicacion;
        }
    } catch (\Exception $e) {
        $user = Usuario::find($data->usuario_id);
        $pretty_user = prettyUser($user);
        $publicacion = Publicacion::find($data->publicacion_id);
        $pretty_publicacion = prettyPublicacion($publicacion);
        $data->usuario_id = $pretty_user;
        $data->publicacion_id = $pretty_publicacion;
    }

    return $data;
}

function prettyMensaje($mensajes){
    $data = $mensajes;
    try{
        foreach($mensajes as $mensaje){
            $emisor = Usuario::find($mensaje->emisor_id);
            $pretty_emisor = prettyUser($emisor);
            $receptor = Usuario::find($mensaje->receptor_id);
            $pretty_receptor = prettyUser($receptor);
            $mensaje->emisor_id = $pretty_emisor;
            $mensaje->receptor_id = $pretty_receptor;
        }
    } catch (\Exception $e) {
        $emisor = Usuario::find($data->emisor_id);
        $pretty_emisor = prettyUser($emisor);
        $receptor = Usuario::find($data->receptor_id);
        $pretty_receptor = prettyUser($receptor);
        $data->emisor_id = $pretty_emisor;
        $data->receptor_id = $pretty_receptor;
    }

    return $data;
}