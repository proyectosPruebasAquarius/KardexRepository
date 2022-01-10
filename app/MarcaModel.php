<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarcaModel extends Model
{
    public $timestamps = false;
    protected $table = 'marcas';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre','estado']; 
}
