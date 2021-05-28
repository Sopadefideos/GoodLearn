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

});
