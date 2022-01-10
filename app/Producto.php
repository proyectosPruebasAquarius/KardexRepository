<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public $timestamps = false;
    protected $table = 'productos'; 
    protected $primaryKey = 'id';
    protected $fillable = ['cod_producto',
    'nombre',
    'id_marca',
    'estado',
    'id_categoria',
    'id_proveedor'
]; 
}
