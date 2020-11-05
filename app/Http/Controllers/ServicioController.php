<?php

namespace App\Http\Controllers;

use App\Servicio;
use App\Http\Resources\ServicioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicio::orderBy('id','desc')->get();
        return ServicioResource::collection($servicios);
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
            'precio' => 'required|numeric',
            'comision' => 'required|numeric',
            'categoria_servicio_id' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $servicio = new Servicio();
            $servicio->nombre = $request->nombre;
            $servicio->precio = $request->precio;
            $servicio->descripcion = $request->descripcion;
            $servicio->comision = $request->comision;
            $servicio->descuento = $request->descuento;
            $servicio->categoria_servicio_id = $request->categoria_servicio_id;

            $servicio->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'El servicio se guardo exitosamente',
                'categoria' => new ServicioResource($servicio)
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
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        $servicio = Servicio::findOrFail($id);
        return new ServicioResource($servicio);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'precio' => 'required',
            'descuento' => 'required',
            'categoria_servicio_id' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $servicio = Servicio::findOrFail($id);
            $servicio->nombre = $request->nombre;
            $servicio->precio = $request->precio;
            $servicio->descripcion = $request->descripcion;
            $servicio->comision = $request->comision;
            $servicio->descuento = $request->descuento;
            $servicio->categoria_servicio_id = $request->categoria_servicio_id;

            $servicio->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'El servicio se actualizo exitosamente',
                'categoria' => new ServicioResource($servicio)
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
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return response()->json([
            'mensaje' => 'Eliminado con éxito',
        ], Response::HTTP_OK);
    }
    public function listar()
    {
        return view('servicios.index');
    }
}
