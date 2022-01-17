<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlmacenZona extends Model
{
    protected $table = 'almacenes_zonas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'estado'
    ]; 
    public $timestamps = false;
}
