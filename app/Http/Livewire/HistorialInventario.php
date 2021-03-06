<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Inventario;
use App\DetalleInventariosModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HistorialInventario extends Component
{
    use LivewireAlert;
    public $inventarios = [];
    public $detalle = [];
    public $id_inventario;

    protected $listeners = ['asignDetalle' => 'asign'];
    public function asign($inventario)
    {
        $this->id_inventario = $inventario['id_inventario'];
       
    }
    public function render()
    {
       
        $this->inventarios = Inventario::join('productos','productos.id','=','inventarios.id_producto')->join('almacenes_zonas','almacenes_zonas.id','inventarios.id_almacen_zona')
        ->join('almacenes','almacenes.id','=','almacenes_zonas.id_almacen')
        ->join('proveedores','proveedores.id','=','productos.id_proveedor')->select('inventarios.cantidad_max','inventarios.cantidad_min','almacenes.nombre as almacen','almacenes_zonas.nombre as zona_almacen',
        'productos.nombre as producto','productos.cod_producto','proveedores.nombre as proveedor')->where('inventarios.id',$this->id_inventario)->get();

        $this->detalle = DetalleInventariosModel::join('documentos','documentos.id','=','detalles_inventarios.id_documento')->join('tipos_documentos','tipos_documentos.id','=','documentos.id_tipo_documento')
        ->select('precio_unitario','concepto','cantidad_saldo','cantidad_entrada','cantidad_salida','total_saldo','total_entrada','total_salida','fecha_registro','tipos_documentos.nombre as tipo_documento',
        'documentos.factura','documentos.factura_proveedor','detalles_inventarios.precio_unitario_proveedor','detalles_inventarios.origen')
        ->where('id_inventario',$this->id_inventario)->orderBy('detalles_inventarios.id','ASC')->get();

        return view('livewire.historial-inventario');
    }
}
