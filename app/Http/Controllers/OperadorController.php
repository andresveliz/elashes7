<?php

namespace App\Http\Controllers;

use App\Operador;
use App\Http\Resources\OperadorResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class OperadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operador = Operador::orderBy('id','asc')->get();
        return OperadorResource::collection($operador);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'ci' => 'required',
            'celular' => 'required|min:1',
            'direccion' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $operador = new Operador();
            $operador->nombre = $request->nombre;
            $operador->apellido = $request->apellido;
            $operador->ci = $request->ci;
            $operador->celular = $request->celular;
            $operador->direccion = $request->direccion;

            $operador->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'El operador se guardo exitosamente',
                'categoria' => new OperadorResource($operador)
            ], Response::HTTP_CREATED);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            response()->json([
                'mensaje' => 'Error al guardar, consulte al Administrador' . $e,
            ], Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Operador  $operador
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $operador = Operador::findOrFail($id);
        return new OperadorResource($operador);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Operador  $operador
     * @return \Illuminate\Http\Response
     */
    public function edit(Operador $operador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Operador  $operador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'apellido' => 'required',
            'ci' => 'required',
            'celular' => 'required|min:1',
            'direccion' => 'required|string'
        ]);

        try {
            DB::beginTransaction();

            $operador = Operador::findOrFail($id);
            $operador->nombre = $request->nombre;
            $operador->apellido = $request->apellido;
            $operador->ci = $request->ci;
            $operador->celular = $request->celular;
            $operador->direccion = $request->direccion;

            $operador->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'El operador se guardo exitosamente',
                'categoria' => new OperadorResource($operador)
            ], Response::HTTP_OK);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            response()->json([
                'mensaje' => 'Error al guardar, consulte al Administrador' . $e,
            ], Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Operador  $operador
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $operador = Operador::findOrFail($id);
        $operador->delete();

        return response()->json([
            'mensaje' => 'Eliminado con éxito',
        ], Response::HTTP_OK);
    }
    public function listar()
    {
        return view('operadores.index');
    }
}
