<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('layouts.home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tiendas', 'TiendaController@index')->name('tiendas');

Route::get('/login', function () {
    return view('auth.inicio-sesion');
})->name('login');

Route::get('/almacenes', 'AlmacenController@index')->name('almacenes');

Route::get('/proveedores', function () {
    return view('layouts.proveedores');
})->name('proveedores');

Route::get('/usuarios', 'UserController@index')->name('usuarios')->middleware('auth');






Route::get('/marcas','MarcaController@index');
Route::get('/categorias','CategoriaController@index');
Route::get('/productos','ProductoController@index');
Route::get('/inventarios','InventarioController@index');
Route::get('/test','InventarioController@create');
Route::get('/tipos-documentos','DocumentoController@index');