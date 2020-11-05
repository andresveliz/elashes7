<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    
    protected $table = 'productos';
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['nombre, precio, cantidad, descuento, categoria_producto_id'];

    public function categoria_producto()
    {
        return $this->belongsTo('App\Categoria_producto', 'categoria_producto_id');
    }

    public function ventas()
    {
        return $this->belongsToMany('App\Venta')->withPivot('cantidad','sub_total');
    }
}
