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
//Route::post('loginok','LoginController@login');
Route::middleware('guest')->group(function(){
    Route::post('trabajos/ticket','TrabajoController@ticket');
});

Route::middleware('auth:api')->group(function () {
Route::resource('categoria-producto', 'CategoriaProductoController');

Route::resource('categoria-servicio','CategoriaServicioController');

Route::resource('operador','OperadorController');
/*Route::get('operador', 'OperadorController@index');
Route::post('operador', 'OperadorController@store');
Route::get('operador/{operador}', 'OperadorController@show');
Route::put('operador/{operador}', 'OperadorController@update');
Route::delete('operador/{operador}/destroy', 'OperadorController@destroy');
*/
Route::resource('producto','ProductoController');

Route::resource('reserva','ReservaController');
Route::patch('reserva/cambiar-estado/{id}','ReservaController@cambiarEstado');

Route::resource('servicio','ServicioController');

Route::resource('trabajo','TrabajoController');

Route::resource('venta','VentaController');

//Route::get('reporte','ReporteController@index');
Route::get('reporte/codigos','ReporteController@codigoMes');
Route::get('reporte/diario','ReporteController@pagoDiario');
Route::get('reporte/ventas','ReporteController@ventaDiario');
Route::get('trabajos/ultimo','TrabajoController@ultimo');

});