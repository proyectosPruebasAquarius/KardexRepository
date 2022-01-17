<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    public $timestamps = false;
    protected $table = 'tipos_documentos';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','estado']; 
}
