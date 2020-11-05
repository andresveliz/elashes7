<?php

namespace App\Http\Controllers;

use App\Categoria_producto;
use App\Http\Resources\CategoriaProductoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class CategoriaProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Categoria_producto::orderBy('id','desc')->get();
        return CategoriaProductoResource::collection($categorias);
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

        ]);

        try {
            DB::beginTransaction();

            $categoria_producto = new Categoria_producto();
            $categoria_producto->nombre = $request->nombre;
            $categoria_producto->descripcion = $request->descripcion;

            $categoria_producto->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'La Categoria se guardo exitosamente',
                'categoria' => new CategoriaProductoResource($categoria_producto)
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
     * @param  \App\Categoria_producto  $categoria_producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria = Categoria_producto::findOrFail($id);
        return new CategoriaProductoResource($categoria);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categoria_producto  $categoria_producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria_producto $categoria_producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categoria_producto  $categoria_producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       /* $this->validate($request, [
            'nombre' => 'required',

        ]);*/
        
        /*try {
            $categoria = Categoria_producto::findOrfail($id);
            return ($categoria);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'slug' => 'NOT FOUND'
            ], 404);
        }*/

        try {
            DB::beginTransaction();

            $categoria = Categoria_producto::findOrFail($id);

            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;

            $categoria->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'La Categoria se actualizo exitosamente',
                'categoria' => new CategoriaProductoResource($categoria)
            ], Response::HTTP_OK);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            
            response()->json([
                'mensaje' => 'Error al guardar, consulte al Administrador' . $e,
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categoria_producto  $categoria_producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria_producto = Categoria_producto::findOrFail($id);
        $categoria_producto->delete();

        return response()->json([
            'mensaje' => 'Eliminado con éxito',
        ], Response::HTTP_OK);
    }

    public function listar()
    {
        return view('categoriaProducto.index');
    }
}
