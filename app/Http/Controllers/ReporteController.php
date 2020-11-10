<?php

namespace App\Http\Controllers;

use App\Operador;
use Illuminate\Http\Request;
use App\Http\Resources\OperadorResource;
use Illuminate\Http\Response;
use DB;

class ReporteController extends Controller
{
    public function index()
    {
        $operador = Operador::orderBy('id','desc')->get();
        return OperadorResource::collection($operador);
    }

    public function listar()
    {
        return view('reportes.index');
    }
}
