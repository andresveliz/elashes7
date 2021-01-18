<?php

namespace App\Http\Controllers;

use App\Operador;
use App\Trabajo;
use Illuminate\Http\Request;
use App\Http\Resources\OperadorResource;
use App\Http\Resources\TrabajoResource;
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

    public function listar()
    {
        return view('reportes.index');
    }
}
