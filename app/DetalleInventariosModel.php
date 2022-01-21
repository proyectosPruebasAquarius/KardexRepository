<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleInventariosModel extends Model
{
    public $timestamps = false;
    protected $table = 'detalles_inventarios';
    protected $primaryKey = 'id';
    protected $fillable = ['id_inventario',
    'estado',
    'concepto',
    'cantidad_saldo',
    'cantidad_salida',
    'cantidad_entrada',
    'precio_unitario',
    'total_saldo',
    'total_entrada',
    'total_salida',
    'fecha_registro',
    'id_documento',
    'precio_unitario_proveedor',
    'origen'
]; 
}
