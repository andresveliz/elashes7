<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operador extends Model
{
    use SoftDeletes;

    protected $table = 'operadores';
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['nombre, apellido, ci, celular, direccion'];

    public function trabajos()
    {
        return $this->hasMany('App\Trabajo');
    }

    public function ventas()
    {
        return $this->hasMany('App\Venta');
    }
}
