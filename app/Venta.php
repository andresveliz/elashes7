<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use SoftDeletes;
    
    protected $table = 'ventas';
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['nombre, apellido, fecha, total, user_id, operador_id'];

    public function operadores()
    {
        return $this->belongsTo('App\Operador', 'operador_id');
    }
    public function productos()
    {
        return $this->belongsToMany('App\Producto')->withPivot('cantidad','sub_total');
    }

}
