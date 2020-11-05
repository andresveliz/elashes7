<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria_producto extends Model
{
    use SoftDeletes;

    protected $table = 'categoria_productos';
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id';

    protected $fillable = ['nombre, descripcion'];

    public function productos()
    {
        return $this->hasMany('App\Producto','id');
    }
}
