<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                          ROLES                           ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todo los roles.
    Route::get('roles', 'RolController@index');
    //Hace una busqueda con una variable GET llamada text.
    Route::get('roles/show', 'RolController@show');
    //Devuelve por ID el rol.
    Route::get('roles/id/{rol}', 'RolController@byIndex');
    //Crear un rol.
    Route::post('rol', 'RolController@store');
    //Modifica un rol
    Route::put('rol/{rol}', 'RolController@update');
    //Elimina un rol
    Route::delete('rol/{rol}', 'RolController@destroy');

    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                          USUARIOS                        ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todo los usuarios.
    Route::get('usuarios', 'UsuarioController@index');
    //Devuelve por ID el usuario.
    Route::get('usuarios/id/{usuario}', 'UsuarioController@byIndex');
    //Hace una busqueda con una variable GET llamada text.
    Route::get('usuarios/show', 'UsuarioController@show');
    //Crear un usuario.
    Route::post('usuario', 'UsuarioController@store');
    //Modifica un usuario
    Route::put('usuario/{usuario}', 'UsuarioController@update');
    //Elimina un usuario
    Route::delete('usuario/{usuario}', 'UsuarioController@destroy');
    //Check usuario
    Route::post('usuario/credentials', 'UsuarioController@checkCredentials');
    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                    TIPO NOTIFICACION                     ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todo los tipos.
    Route::get('tipos', 'Tipo_notificacionController@index');
    //Devuelve por ID el tipo.
    Route::get('tipos/id/{tipo}', 'Tipo_notificacionController@byIndex');
    //Hace una busqueda con una variable GET llamada text.
    Route::get('tipos/show', 'Tipo_notificacionController@show');
    //Crear un tipo.
    Route::post('tipo', 'Tipo_notificacionController@store');
    //Modifica un tipo
    Route::put('tipo/{tipo}', 'Tipo_notificacionController@update');
    //Elimina un tipo
    Route::delete('tipo/{tipo}', 'Tipo_notificacionController@destroy');

    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                       PUBLICACION                        ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las publicacion.
    Route::get('publicaciones', 'PublicacionController@index');
    //Devuelve por ID la publicacion.
    Route::get('publicaciones/id/{publicacion}', 'PublicacionController@byIndex');
    //Hace una busqueda con una variable GET llamada text.
    Route::get('publicaciones/show', 'PublicacionController@show');
    //Crear un tipo.
    Route::post('publicacion/{user}', 'PublicacionController@store');
    //Modifica un tipo
    Route::put('publicacion/{user}/{publicacion}', 'PublicacionController@update');
    //Elimina un tipo
    Route::delete('publicacion/{user}/{publicacion}', 'PublicacionController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                       NOTIFICACION                       ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las notificaciones.
    Route::get('notificaciones', 'NotificacionController@index');
    //Devuelve por ID la notificacion.
    Route::get('notificaciones/id/{notificacion}', 'NotificacionController@byIndex');
    //Hace una busqueda de las notificacion de un usuario.
    Route::get('notificaciones/{usuario}', 'NotificacionController@show');
    //Crear una notifiacion.
    Route::post('notificacion/{usuario}{tipo}', 'NotificacionController@store');
    //Modifica una notifiacion.
    Route::put('notificacion/{notificacion}', 'NotificacionController@update');
    //Elimina una notifiacion.
    Route::delete('notificacion/{notificacion}', 'NotificacionController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                          CURSO                           ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todos los cursos.
    Route::get('cursos/', 'CursoController@index');
    //Devuelve por ID la notificacion.
    Route::get('cursos/id/{curso}', 'CursoController@byIndex');
    //Hace una busqueda de las notificacion de un usuario.
    Route::get('cursos/show', 'CursoController@show');
    //Crear una notifiacion.
    Route::post('curso/', 'CursoController@store');
    //Modifica una notifiacion.
    Route::put('curso/{curso}', 'CursoController@update');
    //Elimina una notifiacion.
    Route::delete('curso/{curso}', 'CursoController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                       CURSO_ALUMNO                       ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todos los cursos_alumnos.
    Route::get('cursos_alumnos/', 'Alumno_cursoController@index');
    //Devuelve por ID la notificacion.
    Route::get('cursos_alumnos/id/{curso_alumno}', 'Alumno_cursoController@byIndex');
    //Hace una busqueda de las notificacion de un cursos_alumnos.
    Route::get('cursos_alumnos/show', 'Alumno_cursoController@show');
    //Crear una curso_alumno.
    Route::post('curso_alumno/{curso}', 'Alumno_cursoController@store');
    //Modifica una curso_alumno.
    Route::put('curso_alumno/{curso_alumno}', 'Alumno_cursoController@update');
    //Elimina una curso_alumno.
    Route::delete('curso_alumno/{curso_alumno}', 'Alumno_cursoController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                        ASIGNATURA                        ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las asignaturas.
    Route::get('asignaturas/', 'AsignaturaController@index');
    //Devuelve por ID la asignatura.
    Route::get('asignaturas/id/{asignatura}', 'AsignaturaController@byIndex');
    //Hace una busqueda de las asignaturas.
    Route::get('asignaturas/show', 'AsignaturaController@show');
    //Crear una asignatura.
    Route::post('asignatura', 'AsignaturaController@store');
    //Modifica una asignatura.
    Route::put('asignatura/{asignatura}', 'AsignaturaController@update');
    //Elimina una asignatura.
    Route::delete('asignatura/{asignatura}', 'AsignaturaController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                     ASIGNATURA_CURSO                     ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las asignaturas_cursos.
    Route::get('asignaturas_cursos/', 'Asignatura_cursoController@index');
    //Devuelve por ID la asignaturas_cursos.
    Route::get('asignaturas_cursos/id/{asignaturas_cursos}', 'Asignatura_cursoController@byIndex');
    //Hace una busqueda de las asignaturas_cursos.
    Route::get('asignaturas_cursos/show', 'Asignatura_cursoController@show');
    //Crear una asignatura_curso.
    Route::post('asignatura_curso/{curso}', 'Asignatura_cursoController@store');
    //Modifica una asignatura_curso.
    Route::put('asignatura_curso/{asignaturas_cursos}', 'Asignatura_cursoController@update');
    //Elimina una asignatura_curso.
    Route::delete('asignatura_curso/{asignaturas_cursos}', 'Asignatura_cursoController@destroy');

    
    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                       ASISTENCIA                         ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las asistencias.
    Route::get('asistencias/', 'AsistenciaController@index');
    //Devuelve por ID la asistencias.
    Route::get('asistencias/id/{asignaturas_cursos}', 'AsistenciaController@byIndex');
    //Hace una busqueda de las asignaturas_cursos.
    Route::get('asistencias/show', 'AsistenciaController@show');
    //Crear una asignatura_curso.
    Route::post('asistencia/', 'AsistenciaController@store');
    //Modifica una asignatura_curso.
    Route::put('asistencia/{asistencia}', 'AsistenciaController@update');
    //Elimina una asignatura_curso.
    Route::delete('asistencia/{asistencia}', 'AsistenciaController@destroy');



    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                       AUTORIZACIONES                     ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las autorizaciones.
    Route::get('autorizaciones/', 'AutorizacionController@index');
    //Devuelve por ID la autorizaciones.
    Route::get('autorizaciones/id/{autorizacion}', 'AutorizacionController@byIndex');
    //Hace una busqueda de las autorizaciones.
    Route::get('autorizaciones/show', 'AutorizacionController@show');
    //Crear una autorizacion.
    Route::post('autorizacion/', 'AutorizacionController@store');
    //Modifica una autorizacion.
    Route::put('autorizacion/{autorizacion}', 'AutorizacionController@update');
    //Elimina una autorizacion.
    Route::delete('autorizacion/{autorizacion}', 'AutorizacionController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                        CONTENIDOS                        ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las contenidos.
    Route::get('contenidos/', 'ContenidoController@index');
    //Devuelve por ID la contenidos.
    Route::get('contenidos/id/{contenido}', 'ContenidoController@byIndex');
    //Hace una busqueda de las contenidos.
    Route::get('contenidos/show', 'ContenidoController@show');
    //Crear una contenido.
    Route::post('contenido/', 'ContenidoController@store');
    //Modifica una contenido.
    Route::put('contenido/{contenido}', 'ContenidoController@update');
    //Elimina una contenido.
    Route::delete('contenido/{contenido}', 'ContenidoController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                          NOTAS                           ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las notas.
    Route::get('notas/', 'NotaController@index');
    //Devuelve por ID la notas.
    Route::get('notas/id/{nota}', 'NotaController@byIndex');
    //Hace una busqueda de las notas.
    Route::get('notas/show', 'NotaController@show');
    //Crear una nota.
    Route::post('nota/', 'NotaController@store');
    //Modifica una nota.
    Route::put('nota/{nota}', 'NotaController@update');
    //Elimina una nota.
    Route::delete('nota/{nota}', 'NotaController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                  COMENTARIOS_PUBLICACION                 ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las comentarios.
    Route::get('comentarios_publicacion/', 'ComentarioPublicacionController@index');
    //Devuelve por ID la comentarios.
    Route::get('comentarios_publicacion/id/{comentario}', 'ComentarioPublicacionController@byIndex');
    //Hace una busqueda de las comentarios.
    Route::get('comentarios_publicacion/show', 'ComentarioPublicacionController@show');
    //Crear una comentario.
    Route::post('comentario_publicacion/', 'ComentarioPublicacionController@store');
    //Modifica una comentario.
    Route::put('comentario_publicacion/{comentario}', 'ComentarioPublicacionController@update');
    //Elimina una comentario.
    Route::delete('comentario_publicacion/{user}/{comentario}', 'ComentarioPublicacionController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                           MENSAJES                       ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las mensajes.
    Route::get('mensajes/', 'MensajeController@index');
    //Devuelve por ID la mensajes.
    Route::get('mensajes/id/{mensaje}', 'MensajeController@byIndex');
    //Hace una busqueda de las mensajes.
    Route::get('mensajes/show', 'MensajeController@show');
    //Crear una mensaje.
    Route::post('mensaje/', 'MensajeController@store');
    //Modifica una mensaje.
    Route::put('mensaje/{mensaje}', 'MensajeController@update');
    //Elimina una mensaje.
    Route::delete('mensaje/{mensaje}', 'MensajeController@destroy');


    /*
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    ||                           PADRES                         ||
    ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    */

    //Lista todas las mensajes.
    Route::get('padres/', 'PadreController@index');
    //Devuelve por ID la mensajes.
    Route::get('padres/id/{mensaje}', 'PadreController@byIndex');
    //Hace una busqueda de las mensajes.
    Route::get('padres/show', 'PadreController@show');
    //Crear una mensaje.
    Route::post('padre/{padre}', 'PadreController@store');
    //Modifica una mensaje.
    Route::put('padre/{padre}', 'PadreController@update');
    //Elimina una mensaje.
    Route::delete('padre/{padre}', 'PadreController@destroy');

});
