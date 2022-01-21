<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $table = 'tiendas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'direccion',
        'estado',
        'codigo',
        'id_almacen'
    ]; 
    public $timestamps = false;
}
