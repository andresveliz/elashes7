<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Servicio;
class ReservaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'title' => $this->nombre,
            'apellido' => $this->apellido,
            'celular' => $this->celular,
            'fecha' => $this->fecha,
            'start' => $this->fecha .'T'.$this->hora.'.000' ,
            'hora' => $this->hora,
            'detalle' => $this->detalle,
            'estado' => $this->estado,
            'user_id' => $this->user_id,
            'servicio_id' => $this->servicio_id,
            'servicio' => $this->servicios,
           // 'servicios' => ReservaResource::collection($this->reservas)
           // 'servicios' =>  ServicioResource::collection($this->servicios),
            'servicios' => new ServicioResource($this->servicios)
        ];
    }
}
