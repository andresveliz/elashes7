<?php

namespace App\Http\Controllers;

use App\Categoria_servicio;
use App\Http\Resources\CategoriaServicioResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class CategoriaServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria_servicio::orderBy('id','desc')->get();
        return CategoriaServicioResource::collection($categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'color' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $categoria_servicio = new Categoria_servicio();
            $categoria_servicio->nombre = $request->nombre;
            $categoria_servicio->color = $request->color;

            $categoria_servicio->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'La Categoria se guardo exitosamente',
                'categoria' => new CategoriaServicioResource($categoria_servicio)
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
     * @param  \App\Categoria_servicio  $categoria_servicio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Categoria_servicio::findOrFail($id);
        return new CategoriaServicioResource($categoria);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categoria_servicio  $categoria_servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria_servicio $categoria_servicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria_servicio  $categoria_servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',

        ]);

        try {
            DB::beginTransaction();

            $categoria_servicio = Categoria_servicio::findOrFail($id);

            $categoria_servicio->nombre = $request->nombre;
            $categoria_servicio->color = $request->color;

            $categoria_servicio->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'La Categoria se actualizo exitosamente',
                'categoria' => new CategoriaServicioResource($categoria_servicio)
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
     * @param  \App\Categoria_servicio  $categoria_servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria_servicio = Categoria_servicio::findOrFail($id);
        $categoria_servicio->delete();

        return response()->json([
            'mensaje' => 'Eliminado con éxito',
        ], Response::HTTP_OK);
    }

    public function listar()
    {
        return view('categoriaServicio.index');
    }
}
