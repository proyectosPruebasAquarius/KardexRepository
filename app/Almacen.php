<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'almacenes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'direccion',
        'estado'
    ]; 
    public $timestamps = false;
}
