<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventarios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_producto',
        'id_almacen',
        'cantidad_max',
        'cantidad_min'
    ]; 
    public $timestamps = false;  //
}
