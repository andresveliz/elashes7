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
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function () {
Route::get('/home', 'HomeController@index')->name('home');

Route::get('reservas','ReservaController@listar')->name('reservas.listar');

Route::get('categoria-servicio','CategoriaServicioController@listar')->name('categoria-servicio.listar');

Route::get('categoria-producto','CategoriaProductoController@listar')->name('categoria-producto.listar');

Route::get('operadores','OperadorController@listar')->name('operadores.listar');

Route::get('productos','productoController@listar')->name('productos.listar');

Route::get('servicios','ServicioController@listar')->name('servicios.listar');

Route::get('trabajos','TrabajoController@listar')->name('trabajos.listar');

Route::get('ventas','VentaController@listar')->name('ventas.listar');

Route::get('reportes','ReporteController@listar')->name('reportes.listar');

Route::get('ticket','TrabajoController@ticket')->name('trabajos.ticket');

Route::get('total','ReporteController@total')->name('reportes.total');

//Route::get('login','LoginController@listar')->name('login.listar');
});