<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trabajo extends Model
{
    use SoftDeletes;
    
    protected $table = 'trabajos';
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['nombre, apellido, celular, fecha, hora, detalle, codigo, operador_id, servicio_id, user_id'];

    public function servicios()
    {
        return $this->belongsTo('App\Servicio', 'servicio_id');
    }
    public function operadores()
    {
        return $this->belongsTo('App\Operador', 'operador_id');
    }
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
