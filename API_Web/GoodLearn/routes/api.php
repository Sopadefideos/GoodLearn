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
    Route::post('curso_alumno/{curso}{usuario}', 'Alumno_cursoController@store');
    //Modifica una curso_alumno.
    Route::put('curso_alumno/{curso_alumno}', 'Alumno_cursoController@update');
    //Elimina una curso_alumno.
    Route::delete('curso_alumno/{curso_alumno}', 'Alumno_cursoController@destroy');
});
