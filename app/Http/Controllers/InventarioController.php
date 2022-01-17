<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventario;
use App\DetalleInventariosModel;
class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventarios = Inventario::join('productos','productos.id','=','inventarios.id_producto')->join('proveedores','proveedores.id','=','productos.id_proveedor')
        ->join('almacenes_zonas','almacenes_zonas.id','=','inventarios.id_almacen_zona')->join('almacenes', 'almacenes.id','=','almacenes_zonas.id_almacen')
        ->where('inventarios.estado',1)->select('productos.id as producto','productos.nombre as nombre_producto','productos.cod_producto','almacenes_zonas.id as almacen_zona','almacenes_zonas.nombre as almacen_zona_nombre',
        'almacenes.nombre as nombre_almacen','almacenes.id as almacen','cantidad_min as min','cantidad_max as max','inventarios.id as id_inventario','proveedores.nombre as proveedor')->get();
        return view('partials.inventarios')->with('inventarios',$inventarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $promedioPonderado = DetalleInventariosModel::whereNotNull('cantidad_entrada')->select('cantidad_entrada','precio_unitario')->orderBy('id','DESC')->first();

            return $promedioPonderado;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
