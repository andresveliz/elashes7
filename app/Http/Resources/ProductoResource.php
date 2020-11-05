<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
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
            'cantidad' => $this->cantidad,
            'descuento' => $this->descuento,
            'categoria_id' => $this->categoria_producto_id,
            'categorias' => $this->categoria_producto->nombre
            //'categoria' => CategoriaProductoResource::collection($this->categoria_producto)
        ];
    }
}
