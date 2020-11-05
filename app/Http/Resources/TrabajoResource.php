<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrabajoResource extends JsonResource
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
            'apellido' => $this->apellido,
            'celular' => $this->celular,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'detalle' => $this->detalle,
            'codigo' => $this->codigo,
            'user_id' => $this->user_id,
            'servicio_id' => $this->servicio_id,
            'operador_id' => $this->operador_id,
            'servicio' => $this->servicios,
            'operador' => $this->operadores
            //'categoria' => CategoriaProductoResource::collection($this->categoria_producto)
        ];
    }
}
