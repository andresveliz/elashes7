<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria_servicio extends Model
{
    use SoftDeletes;

    protected $table = 'categoria_servicios';
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['nombre, color'];

    public function servicios()
    {
        return $this->hasMany('App\Servicio','id');
    }

}
