<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class VentaResource extends JsonResource
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
            'fecha' => $this->fecha,
            'total' => $this->total,
            'user_id' => $this->user_id,
            'mes' => Carbon::createFromFormat('Y-m-d', $this->fecha)->format('yy-m'),
            'operador_id' => $this->operador_id,
            'detalle' => $this->productos
            //'categoria' => CategoriaProductoResource::collection($this->categoria_producto)
        ];
    }
}
