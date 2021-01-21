<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;
    
    protected $table = 'servicios';
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['nombre, precio, descripcion, comision, descuento, categoria_servicio_id'];

    public function categoria_servicio()
    {
        return $this->belongsTo('App\Categoria_servicio', 'categoria_servicio_id');
    }

    public function reservas()
    {
        return $this->hasMany('App\Categoria_servicio', 'id');
    }

    public function trabajos()
    {
        return $this->hasMany('App\Trabajo');
    }

}
