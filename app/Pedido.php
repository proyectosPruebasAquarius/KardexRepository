<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos_productos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'cantidad',
        'precio',
        'estado',
        'fecha_entrega',
        'id_producto'
    ]; 
    public $timestamps = false;
}
