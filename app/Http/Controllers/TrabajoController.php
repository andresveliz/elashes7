<?php

namespace App\Http\Controllers;

use App\Trabajo;
use App\Http\Resources\TrabajoResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Carbon\Carbon;

class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trabajos = Trabajo::orderBy('id','desc')->get();
        return TrabajoResource::collection($trabajos);
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
        $ultimo = Trabajo::orderBy('id','desc')->first();
    
        if((Carbon::now()->isSameMonth(Carbon::yesterday())) == true ){
            $contador = intval(substr($ultimo->codigo,-4))+1;
            
        }
        else{
            $contador = 1;
        };
        $codigo = str_pad($contador,4,'0',STR_PAD_LEFT);
        $completo = substr((Carbon::now()->format('F')),0,3).$codigo;


        $this->validate($request, [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'celular' => 'required|numeric',
            'fecha' => 'required|date',
            'hora' => 'required',
           // 'user_id' => 'required|integer',
            'servicio_id' => 'required|integer',
            'operador_id' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $trabajo = new Trabajo();
            $trabajo->nombre = $request->nombre;
            $trabajo->apellido = $request->apellido;
            $trabajo->celular = $request->celular;
            $trabajo->fecha = \Carbon\Carbon::parse($request->fecha)->format('Y-m-d');
            $trabajo->hora = $request->hora;
            $trabajo->detalle = $request->detalle;
            $trabajo->codigo = $completo;
            $trabajo->user_id = 1;
            $trabajo->servicio_id = $request->servicio_id;
            $trabajo->operador_id = $request->operador_id;

            $trabajo->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'La trabajo se guardo exitosamente',
                'categoria' => new TrabajoResource($trabajo)
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
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trabajo = Trabajo::findOrFail($id);
        return new TrabajoResource($trabajo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function edit(Trabajo $trabajo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'celular' => 'required|numeric',
            'fecha' => 'required|date',
            'hora' => 'required',
            //'detalle' => 'string',
           // 'codigo' => 'required',
            //'user_id' => 'required|integer',
            'servicio_id' => 'required|integer',
            'operador_id' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $trabajo = Trabajo::findOrFail($id);
            $trabajo->nombre = $request->nombre;
            $trabajo->apellido = $request->apellido;
            $trabajo->celular = $request->celular;
            $trabajo->fecha = Carbon::parse($request->fecha)->format('Y-m-d');
            $trabajo->hora = $request->hora;
            $trabajo->detalle = $request->detalle;
            $trabajo->user_id = 1;
            $trabajo->servicio_id = $request->servicio_id;
            $trabajo->operador_id = $request->operador_id;

            $trabajo->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'La trabajo se actualizo exitosamente',
                'categoria' => new TrabajoResource($trabajo)
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
     * @param  \App\Trabajo  $trabajo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trabajo = Trabajo::findOrFail($id);
        $trabajo->delete();

        return response()->json([
            'mensaje' => 'Eliminado con éxito',
        ], Response::HTTP_OK);
    }
    public function listar()
    {
        return view('trabajos.index');
    }
    /*public function codigo(date $fecha)
    {
        $contador = 0;
        $codigo;
        $completo;
        if((Carbon::now()->isSameMonth(Carbon::yesterday())) == true ){
            $contador++;
            
        }
        else{
            $contador = 0;
        };
        $codigo = str_pad($contador,4,'0',STR_PAD_LEFT);
        $completo = substr((Carbon::parse($fecha)->format('F')),0,3)+'-'+$codigo;

        return $completo;
    }*/
}
