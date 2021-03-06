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

Route::view('/', 'welcome')->name('admin');
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
//PADRES
Route::get('admin/usuarios/padre/{padre}', 'App\Http\Controllers\PadreController@content')->name('padre.content');
Route::get('admin/usuarios/padre/{padre}/create', 'App\Http\Controllers\PadreController@create')->name('padre.create');
Route::post('admin/usuarios/padre/{padre}/store', 'App\Http\Controllers\PadreController@store')->name('padre.store');
Route::get('admin/usuarios/padre/{padre}/edit', 'App\Http\Controllers\PadreController@edit')->name('padre.edit');
Route::post('admin/usuarios/padre/{padre}/update', 'App\Http\Controllers\PadreController@update')->name('padre.update');
Route::delete('admin/usuarios/padre/{padre}', 'App\Http\Controllers\PadreController@destroy')->name('padre.destroy');


//ASIGNATURA
Route::get('admin/asignaturas', 'App\Http\Controllers\AsignaturaController@index')->name('asignaturas');
Route::get('admin/asignatura/create', 'App\Http\Controllers\AsignaturaController@create')->name('asignatura.create');
Route::post('admin/asignatura/store', 'App\Http\Controllers\AsignaturaController@store')->name('asignatura.store');
Route::get('admin/asignatura/{asignatura}/edit', 'App\Http\Controllers\AsignaturaController@edit')->name('asignatura.edit');
Route::put('admin/asignatura/{asignatura}/edit', 'App\Http\Controllers\AsignaturaController@update')->name('asignatura.update');
Route::delete('admin/asignatura/{asignatura}', 'App\Http\Controllers\AsignaturaController@destroy')->name('asignatura.delete');

//CONTENIDO ASIGNATURA
Route::get('admin/asignatura/{asignatura}/content', 'App\Http\Controllers\AsignaturaController@content')->name('asignatura.content');
//ASISTENCIAS
Route::get('admin/asignatura/{asignatura}/content/asistencia/create', 'App\Http\Controllers\AsistenciaController@create')->name('asignatura.asistencia.create');
Route::post('admin/asignatura/{asignatura}/content/asistencia/store', 'App\Http\Controllers\AsistenciaController@store')->name('asignatura.asistencia.store');
Route::get('admin/asignatura/{asignatura}/content/asistencia/{asistencia}/edit', 'App\Http\Controllers\AsistenciaController@edit')->name('asignatura.asistencia.edit');
Route::put('admin/asignatura/content/asistencia/{asistencia}/edit', 'App\Http\Controllers\AsistenciaController@update')->name('asignatura.asistencia.update');
Route::delete('admin/asignatura/content/asistencia/{asistencia}', 'App\Http\Controllers\AsistenciaController@destroy')->name('asignatura.asistencia.delete');
//NOTAS
Route::get('admin/asignatura/{asignatura}/content/nota/create', 'App\Http\Controllers\NotaController@create')->name('asignatura.nota.create');
Route::post('admin/asignatura/{asignatura}/content/nota/store', 'App\Http\Controllers\NotaController@store')->name('asignatura.nota.store');
Route::get('admin/asignatura/{asignatura}/content/nota/{nota}/edit', 'App\Http\Controllers\NotaController@edit')->name('asignatura.nota.edit');
Route::put('admin/asignatura/content/nota/{nota}/edit', 'App\Http\Controllers\NotaController@update')->name('asignatura.nota.update');
Route::delete('admin/asignatura/content/nota/{nota}', 'App\Http\Controllers\NotaController@destroy')->name('asignatura.nota.delete');
//AUTORIZACIONES
Route::get('admin/asignatura/{asignatura}/content/autorizacion/content/{url_name}', 'App\Http\Controllers\AutorizacionController@content')->name('asignatura.autorizacion.content');
Route::get('admin/asignatura/{asignatura}/content/autorizacion/create', 'App\Http\Controllers\AutorizacionController@create')->name('asignatura.autorizacion.create');
Route::post('admin/asignatura/{asignatura}/content/autorizacion/store', 'App\Http\Controllers\AutorizacionController@store')->name('asignatura.autorizacion.store');
Route::get('admin/asignatura/{asignatura}/content/autorizacion/{autorizacion}/edit', 'App\Http\Controllers\AutorizacionController@edit')->name('asignatura.autorizacion.edit');
Route::put('admin/asignatura/content/autorizacion/{autorizacion}/edit', 'App\Http\Controllers\AutorizacionController@update')->name('asignatura.autorizacion.update');
Route::delete('admin/asignatura/content/autorizacion/{autorizacion}', 'App\Http\Controllers\AutorizacionController@destroy')->name('asignatura.autorizacion.delete');
//CONTENIDO
Route::get('admin/asignatura/{asignatura}/content/contenido/content/{url_name}', 'App\Http\Controllers\ContenidoController@content')->name('asignatura.contenido.content');
Route::get('admin/asignatura/{asignatura}/content/contenido/create', 'App\Http\Controllers\ContenidoController@create')->name('asignatura.contenido.create');
Route::post('admin/asignatura/{asignatura}/content/contenido/store', 'App\Http\Controllers\ContenidoController@store')->name('asignatura.contenido.store');
Route::get('admin/asignatura/{asignatura}/content/contenido/{contenido}/edit', 'App\Http\Controllers\ContenidoController@edit')->name('asignatura.contenido.edit');
Route::put('admin/asignatura/content/contenido/{contenido}/edit', 'App\Http\Controllers\ContenidoController@update')->name('asignatura.contenido.update');
Route::delete('admin/asignatura/content/contenido/{contenido}', 'App\Http\Controllers\ContenidoController@destroy')->name('asignatura.contenido.delete');

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

//PUBLICACIONES
Route::get('admin/home', 'App\Http\Controllers\PublicacionController@index')->name('home');
Route::post('admin/home/publicacion/create/{user}', 'App\Http\Controllers\PublicacionController@store')->name('publicacion.store');
Route::get('admin/home/publicacion/{publicacion}/edit', 'App\Http\Controllers\PublicacionController@edit')->name('publicacion.edit');
Route::put('admin/home/publicacion/{user}/{publicacion}/edit', 'App\Http\Controllers\PublicacionController@update')->name('publicacion.update');
Route::delete('admin/home/publicacion/{user}/{publicacion}', 'App\Http\Controllers\PublicacionController@destroy')->name('publicacion.delete');

//COMENTARIOS
Route::get('admin/home/{publicacion}/coments', 'App\Http\Controllers\ComentarioPublicacionController@content')->name('publicacion.comentario.content');
Route::post('admin/home/publicacion/coments/create', 'App\Http\Controllers\ComentarioPublicacionController@store')->name('publicacion.comentario.store');
Route::get('admin/home/publicacion/coments/{comentario}/edit', 'App\Http\Controllers\ComentarioPublicacionController@edit')->name('publicacion.comentario.edit');
Route::put('admin/home/publicacion/coments/edit/{comentario}', 'App\Http\Controllers\ComentarioPublicacionController@update')->name('publicacion.comentario.update');
Route::delete('admin/home/publicacion/coments/{user}/{comentario}', 'App\Http\Controllers\ComentarioPublicacionController@destroy')->name('publicacion.comentario.delete');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

