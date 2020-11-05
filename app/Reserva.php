<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;
    
    protected $table = 'reservas';
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['nombre, apellido, celular, fecha, hora, detalle, estado, user_id, servicio_id'];

    public function servicios()
    {
        return $this->belongsTo('App\Servicio', 'servicio_id');
    }
    
}
