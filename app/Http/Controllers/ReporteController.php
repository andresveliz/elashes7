<?php

namespace App\Http\Controllers;

use App\Operador;
use App\Trabajo;
use App\Venta;
use Illuminate\Http\Request;
use App\Http\Resources\OperadorResource;
use App\Http\Resources\TrabajoResource;
use App\Http\Resources\VentaResource;
use Illuminate\Http\Response;
use DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        $operador = Operador::orderBy('id','desc')->get();
        return OperadorResource::collection($operador);
    }
    public function codigoMes()
    {
        $mes = Carbon::now()->format('m');
        $codigos = Trabajo::whereMonth('fecha' , '=', $mes)->get();
        return TrabajoResource::collection($codigos);
    }
    public function pagoDiario(Request $request)
    {
        $fecha = \Carbon\Carbon::parse($request->fecha)->format('Y-m-d');
        $dia = Trabajo::where('fecha', '=', $fecha)->get();
        return TrabajoResource::collection($dia);
    }
    public function ventaDiario(Request $request)
    {
        $fecha = \Carbon\Carbon::parse($request->fecha)->format('Y-m-d');
        $dia = Venta::where('fecha', '=', $fecha)->get();
        return VentaResource::collection($dia);
    }

    public function listar()
    {
        return view('reportes.index');
    }

    public function total()
    {
        return view('reportes.total');
    }
}
