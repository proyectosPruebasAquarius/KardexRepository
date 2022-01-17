<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    public $timestamps = false;
    protected $table = 'documentos';
    protected $primaryKey = 'id';
    protected $fillable = ['factura','factura_proveedor','id_tipo_documento']; 
}
