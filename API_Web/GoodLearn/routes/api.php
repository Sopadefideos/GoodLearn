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
});
