<?php

namespace App\Http\Controllers;

use App\Venta;
use App\Http\Resources\VentaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = Venta::orderBy('id','desc')->get();
        return VentaResource::collection($ventas);
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
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'fecha' => 'required',
            'user_id' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $venta = new Venta();
            $venta->nombre = $request->nombre;
            $venta->apellido = $request->apellido;
            $venta->fecha = $request->fecha;
            $venta->total = $request->total;
            $venta->user_id = $request->user_id;
            $venta->operador_id = $request->operador_id;

            $venta->save();

            
            DB::commit();

            return response()->json([
                'mensaje' => 'La venta se guardo exitosamente',
                'categoria' => new VentaResource($venta)
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
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        $venta = Venta::findOrFail($id);
        return new VentaResource($venta);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'fecha' => 'required|date',
            'user_id' => 'required|integer',
        ]);

        try {
            DB::beginTransaction();

            $venta = new Venta();
            $venta->nombre = $request->nombre;
            $venta->apellido = $request->apellido;
            $venta->fecha = $request->fecha;
            $venta->total = '100';
            $venta->user_id = $request->user_id;
            $venta->operador_id = $request->operador_id;

            $venta->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'La venta se guardo exitosamente',
                'categoria' => new VentaResource($venta)
            ], Response::HTTP_CREATED);

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
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $venta = Venta::findOrFail($id);
        $venta->delete();

        return response()->json([
            'mensaje' => 'Eliminado con éxito',
        ], Response::HTTP_OK);
    }
    public function listar()
    {
        return view('ventas.index');
    }
}
