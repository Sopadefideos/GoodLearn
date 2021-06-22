<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::view('/admin', 'welcome')->name('admin');
Route::view('/admin/login', 'auth.login')->name('admin/login');
Route::post('loginAdmin', 'App\Http\Controllers\UsuarioController@loginAdmin')->name('loginAdmin');
Route::post('logoutAdmin', 'App\Http\Controllers\UsuarioController@logout')->name('logoutAdmin');

//USUARIO
Route::get('admin/usuarios', 'App\Http\Controllers\UsuarioController@index')->name('usuarios');
Route::get('admin/usuario/create', 'App\Http\Controllers\UsuarioController@create')->name('usuario.create');
Route::post('admin/usuario/store', 'App\Http\Controllers\UsuarioController@store')->name('usuario.store');
Route::get('admin/usuario/{usuario}/edit', 'App\Http\Controllers\UsuarioController@edit')->name('usuario.edit');
Route::put('admin/usuario/{usuario}/edit', 'App\Http\Controllers\UsuarioController@update')->name('usuario.update');
Route::delete('admin/usuario/{usuario}', 'App\Http\Controllers\UsuarioController@destroy')->name('usuario.delete');

//ASIGNATURA
Route::get('admin/asignaturas', 'App\Http\Controllers\AsignaturaController@index')->name('asignaturas');
Route::get('admin/asignatura/create', 'App\Http\Controllers\AsignaturaController@create')->name('asignatura.create');
Route::post('admin/asignatura/store', 'App\Http\Controllers\AsignaturaController@store')->name('asignatura.store');
Route::get('admin/asignatura/{asignatura}/edit', 'App\Http\Controllers\AsignaturaController@edit')->name('asignatura.edit');
Route::put('admin/asignatura/{asignatura}/edit', 'App\Http\Controllers\AsignaturaController@update')->name('asignatura.update');
Route::delete('admin/asignatura/{asignatura}', 'App\Http\Controllers\AsignaturaController@destroy')->name('asignatura.delete');

//CURSO
Route::get('admin/cursos', 'App\Http\Controllers\CursoController@index')->name('cursos');
Route::get('admin/curso/create', 'App\Http\Controllers\CursoController@create')->name('curso.create');
Route::post('admin/curso/store', 'App\Http\Controllers\CursoController@store')->name('curso.store');
Route::get('admin/curso/{curso}/edit', 'App\Http\Controllers\CursoController@edit')->name('curso.edit');
Route::put('admin/curso/{curso}/edit', 'App\Http\Controllers\CursoController@update')->name('curso.update');
Route::delete('admin/curso/{curso}', 'App\Http\Controllers\CursoController@destroy')->name('curso.delete');

//CONTENIDO DE CURSOS
Route::get('admin/curso/{curso}/content', 'App\Http\Controllers\CursoController@content')->name('curso.content');
//ASIGNATURAS_CURSO
Route::get('admin/curso/{curso}/content/asignatura/create', 'App\Http\Controllers\Asignatura_cursoController@create')->name('curso.asignatura.create');
Route::post('admin/curso/{curso}/content/asignatura/store', 'App\Http\Controllers\Asignatura_cursoController@store')->name('curso.asignatura.store');
Route::get('admin/curso/{curso}/content/asignatura/{asignaturas_cursos}/edit', 'App\Http\Controllers\Asignatura_cursoController@edit')->name('curso.asignatura.edit');
Route::put('admin/curso/content/asignatura/{asignaturas_cursos}/edit', 'App\Http\Controllers\Asignatura_cursoController@update')->name('curso.asignatura.update');
Route::delete('admin/curso/content/asignatura/{asignaturas_cursos}', 'App\Http\Controllers\Asignatura_cursoController@destroy')->name('curso.asignatura.delete');
//ALUMNOS_CURSO
Route::get('admin/curso/{curso}/content/alumno/create', 'App\Http\Controllers\Alumno_cursoController@create')->name('curso.alumno.create');
Route::post('admin/curso/{curso}/content/alumno/store', 'App\Http\Controllers\Alumno_cursoController@store')->name('curso.alumno.store');
Route::get('admin/curso/{curso}/content/alumno/{curso_alumno}/edit', 'App\Http\Controllers\Alumno_cursoController@edit')->name('curso.alumno.edit');
Route::put('admin/curso/content/alumno/{curso_alumno}/edit', 'App\Http\Controllers\Alumno_cursoController@update')->name('curso.alumno.update');
Route::delete('admin/curso/content/alumno/{curso_alumno}', 'App\Http\Controllers\Alumno_cursoController@destroy')->name('curso.alumno.delete');


Route::view('admin/home', 'dashboard')->name('home');

Route::group(['namespace' => ''], function () {
	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

