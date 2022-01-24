<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Inventario;
use App\Producto;
use App\Almacen;
use App\AlmacenZona;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Inventarios extends Component
{
    use LivewireAlert;
    public $productos = [];
    public $almacenes = [];
    public $zonas = [];
    public $producto;
    public $almacen;
    public $zona_almacen;
    public $min;
    public $max;
    public $id_inventario;
    protected $listeners = ['resetNamesInventarios' => 'resetInput','asignInventario' => 'asignInventario','dropByStateInventario' => 'dropByState'];

    protected $rules = [
        'min' => 'required|min:1',
        'max' => 'required|min:1',
        'producto' => 'required',
        'almacen' => 'required',
        'zona_almacen' => 'required',
    ];
    protected  $messages = [
        'min.required' => 'La Cantidad Minima es Obligatoria',
        'min.min' => 'La Cantidad Minima debe contener un Mímino de :min Caracteres',        
        'max.required' => 'La Cantidad Maxima es Obligatoriao',
        'max.min' => 'La Cantidad Maxima debe contener un Mímino de :min Caracteres', 
        'almacen.required' => 'El Almacen es Obligatorio',
        'producto.required' => 'El Producto es Obligatorio',
        'zona_almacen.required' => 'El Almacen es Obligatorio',
    ];
    public function asignInventario($inventario)
    {
        $this->id_inventario = $inventario['id_inventario'];
        $this->producto = $inventario['producto'];
        $this->zona_almacen = $inventario['almacen_zona'];
        $this->almacen = $inventario['almacen'];
        $this->min = $inventario['min'];        
        $this->max = $inventario['max'];
        $this->zonas = AlmacenZona::where('estado',1)->where('id_almacen',$this->almacen)->select('nombre','id')->get();
        $this->almacenes = Almacen::where('estado',1)->select('nombre','id')->get();
        $this->productos = Producto::where('estado',1)->select('productos.cod_producto as nombre','id')->get();
    }


    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['min','max','id_inventario','producto','almacen','zona_almacen']);
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createInventario()
    {
        $this->validate();
        if ($this->id_inventario) {
            try {                                
                Inventario::where('id',$this->id_inventario)->update([
                    'id_producto' => $this->producto,
                    'id_almacen_zona' => $this->zona_almacen,
                    'cantidad_min' => $this->min,
                    'cantidad_max' => $this->max,
                   
                ]);
                session(['alert' => ['type' => 'success', 'message' => 'Inventario Actualizado con éxito.','position' =>'center']]);
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/inventarios');
            } catch (\Exception $th) {
                session(['alert' => ['type' => 'error', 'message' => 'Ha Ocurrido un error.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/inventarios');
            }
        } else {
            try {
                Inventario::create([
                    'id_producto' => $this->producto,
                    'id_almacen_zona' => $this->zona_almacen,
                    'cantidad_min' => $this->min,
                    'cantidad_max' => $this->max,
                ]);
                session(['alert' => ['type' => 'success', 'message' => 'Inventario Guardado con éxito.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/inventarios');
            } catch (\Exception $th) {
                session(['alert' => ['type' => 'error', 'message' => $th->getMessage(),'position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/inventarios');
            }
        }
        
    }
    public function dropByState($id)
    {
        try {
            Inventario::where('id',$id)->update(['estado' => 0]);               
            session(['alert' => ['type' => 'success', 'message' => 'Inventario eliminado con éxito.']]);
            return redirect()->to('/inventarios');
        } catch (\Exception $th) {
           
            $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                'position' => 'center'
            ]);
        }
    }

    public function render()
    {
        if(!empty($this->almacen)) {
            $this->zonas = AlmacenZona::where('estado',1)->where('id_almacen',$this->almacen)->select('nombre','id')->get();
        }   
        $productoUsed = Inventario::select('id_producto')->where('estado',1)->get();
        $this->almacenes = Almacen::where('estado',1)->select('nombre','id')->get();
        $this->productos = Producto::where('estado',1)->whereNotIn('id',$productoUsed)->select('productos.cod_producto as nombre','id')->get();
        return view('livewire.inventarios');
    }
}
