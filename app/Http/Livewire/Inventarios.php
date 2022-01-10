<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Inventario;
use App\Producto;
use App\Almacen;

class Inventarios extends Component
{
    public $productos = [];
    public $almacenes = [];
    public $producto;
    public $almacen;
    public $min;
    public $max;
    public $id_inventario;
    protected $listeners = ['resetNamesInventarios' => 'resetInput','asignInventario' => 'asignInventario'];

    protected $rules = [
        'min' => 'required|min:1',
        'max' => 'required|min:1',
        'producto' => 'required',
        'almacen' => 'required',
        
    ];
    protected  $messages = [
        'min.required' => 'La Cantidad Minima es Obligatoria',
        'min.min' => 'La Cantidad Minima debe contener un Mímino de :min Caracteres',        
        'max.required' => 'La Cantidad Maxima es Obligatoriao',
        'max.min' => 'La Cantidad Maxima debe contener un Mímino de :min Caracteres', 
        'almacen.required' => 'El Almacen es Obligatorio',
        'producto.required' => 'El Producto es Obligatorio',
       
    ];
    public function asignInventario($inventario)
    {
        $this->id_inventario = $inventario['id_inventario'];
        $this->producto = $inventario['producto'];
        $this->almacen = $inventario['almacen'];

        $this->min = $inventario['min'];        
        $this->max = $inventario['max'];
       
        $this->almacenes = Almacen::where('estado',1)->select('nombre','id')->get();
        $this->productos = Producto::where('estado',1)->select('productos.cod_producto as nombre','id')->get();
    }


    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['min','max','id_inventario','producto','almacen']);
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createInventario()
    {
        if ($this->id_inventario) {
            try {                                
                Inventario::where('id',$this->id_inventario)->update([
                    'id_producto' => $this->producto,
                    'id_almacen' => $this->almacen,
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
                    'id_almacen' => $this->almacen,
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

    public function render()
    {
        $this->almacenes = Almacen::where('estado',1)->select('nombre','id')->get();
        $this->productos = Producto::where('estado',1)->select('productos.cod_producto as nombre','id')->get();
        return view('livewire.inventarios');
    }
}
