<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Http\Resources\ProductoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::orderBy('id','desc')->get();
        return ProductoResource::collection($productos);
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
            'precio' => 'required',
            'cantidad' => 'required|integer',
            'categoria_producto_id' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->precio = $request->precio;
            $producto->cantidad = $request->cantidad;
            $producto->descuento = $request->descuento;
            $producto->categoria_producto_id = $request->categoria_producto_id;

            $producto->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'El producto se guardo exitosamente',
                'categoria' => new ProductoResource($producto)
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
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return new ProductoResource($producto);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required',
            'precio' => 'required',
            'cantidad' => 'required|integer',
            
            'categoria_producto_id' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $producto = Producto::findOrFail($id);
            $producto->nombre = $request->nombre;
            $producto->precio = $request->precio;
            $producto->cantidad = $request->cantidad;
            $producto->descuento = $request->descuento;
            $producto->categoria_producto_id = $request->categoria_producto_id;

            $producto->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'El producto se actualizo exitosamente',
                'categoria' => new ProductoResource($producto)
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
     * @param  \App\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return response()->json([
            'mensaje' => 'Eliminado con éxito',
        ], Response::HTTP_OK);
    }

    public function listar()
    {
        return view('productos.index');
    }
}
