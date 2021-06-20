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
Route::post('store', 'App\Http\Controllers\UsuarioController@store')->name('store');

Route::view('/home', 'dashboard')->name('home');

Route::group(['namespace' => 'home'], function () {
	Route::get('table-list', function () {
		$usuarios = Http::get('https://good-learn-jjrdb.ondigitalocean.app/api/usuarios/')->json();
		return view('pages.table_list')->with('usuarios', $usuarios);
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('formCreateUser', function () {
		return view('pages.formCreateUser');
	})->name('formCreateUser');

	Route::get('formUpdateUser', function (Request $request) {
		$usuario = Http::get('https://good-learn-jjrdb.ondigitalocean.app/api/usuarios/id/'.$request['user'])->json();
		$roles = Http::get('https://good-learn-jjrdb.ondigitalocean.app/api/roles/')->json();
		return view('pages.formUpdateUser')->with('usuario', $usuario)->with('roles', $roles);
	})->name('formUpdateUser');

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

