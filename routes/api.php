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

Route::resource('categoria-producto', 'CategoriaProductoController');

Route::resource('categoria-servicio','CategoriaServicioController');

Route::resource('operador','OperadorController');

Route::resource('producto','ProductoController');

Route::resource('reserva','ReservaController');
Route::patch('reserva/cambiar-estado/{id}','ReservaController@cambiarEstado');

Route::resource('servicio','ServicioController');

Route::resource('trabajo','TrabajoController');

Route::resource('venta','VentaController');