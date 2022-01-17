<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoDocumento;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = TipoDocumento::select('id','nombre')->where('estado',1)->get();
        return view('partials.tipos-documentos')->with('documentos',$documentos);
    }
}
