<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicioResource extends JsonResource
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
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'descripcion' => $this->descripcion,
            'comision' => $this->comision,
            'descuento' => $this->descuento,
            'categoria_id' => $this->categoria_servicio_id,
            'categorias' => $this->categoria_servicio->nombre,
            'color' => $this->categoria_servicio->color,
            //'reservas' => ReservaResource::collection($this->reservas)
            
        ];
    }
}
