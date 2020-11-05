<?php

namespace App\Http\Controllers;

use App\Reserva;
use App\Http\Resources\ReservaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DB;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservas = Reserva::orderBy('id','desc')->get();
        return ReservaResource::collection($reservas);
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
            'celular' => 'required|numeric',
            'fecha' => 'required|date',
            'hora' => 'required',
            'servicio_id' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $reserva = new Reserva();
            $reserva->nombre = $request->nombre;
            $reserva->apellido = $request->apellido;
            $reserva->celular = $request->celular;
            $reserva->fecha = \Carbon\Carbon::parse($request->fecha)->format('Y-m-d');
            $reserva->hora = $request->hora;
            $reserva->detalle = $request->detalle;
            $reserva->user_id = '1';
            $reserva->servicio_id = $request->servicio_id;

            $reserva->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'La reserva se guardo exitosamente',
                'categoria' => new ReservaResource($reserva)
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
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reserva = Reserva::findOrFail($id);
        return new ReservaResource($reserva);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reserva  $reserva
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
            //'user_id' => 1,
            'servicio_id' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $reserva = Reserva::findOrFail($id);
            
            $reserva->nombre = $request->nombre;
            $reserva->apellido = $request->apellido;
            $reserva->celular = $request->celular;
            $reserva->fecha = Carbon::parse($request->fecha)->format('Y-m-d');
            $reserva->hora = $request->hora;
            $reserva->detalle = $request->detalle;
            //$reserva->user_id = 1;
            $reserva->servicio_id = $request->servicio_id;

            $reserva->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'La reserva se guardo exitosamente',
                'categoria' => new ReservaResource($reserva)
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
     * @param  \App\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->delete();

        return response()->json([
            'mensaje' => 'Eliminado con éxito',
        ], Response::HTTP_OK);
    }

    public function listar()
    {
        return view('reservas.index');
    }

    public function cambiarEstado(Request $request, $id)
    {
        $this->validate($request, [
            'estado' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $reserva = Reserva::findOrFail($id);
            
            $reserva->estado = $request->estado;
        
            $reserva->save();

            DB::commit();

            return response()->json([
                'mensaje' => 'Se modifico el estado exitosamente',
                'categoria' => new ReservaResource($reserva)
            ], Response::HTTP_CREATED);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();

            response()->json([
                'mensaje' => 'Error al guardar, consulte al Administrador' . $e,
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
