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
       
        $this->inventarios = Inventario::join('productos','productos.id','=','inventarios.id_producto')->join('almacenes','almacenes.id','=','inventarios.id_almacen')
        ->join('proveedores','proveedores.id','=','productos.id_proveedor')->select('inventarios.cantidad_max','inventarios.cantidad_min','almacenes.nombre as almacen',
        'productos.nombre as producto','productos.cod_producto','proveedores.nombre as proveedor')->where('inventarios.id',$this->id_inventario)->get();

        $this->detalle = DetalleInventariosModel::select('concepto','cantidad_saldo','cantidad_entrada','cantidad_salida','total_saldo','total_entrada','total_salida','fecha_registro')
        ->where('id_inventario',$this->id_inventario)->get();
        return view('livewire.historial-inventario');
    }
}
