<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Producto;
use App\Almacen;
use App\Proveedor;
use App\MarcaModel;
use App\Categoria;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Productos extends Component
{
    use LivewireAlert;
    public $categorias = [];
    public $marcas = [];
    public $proveedores = [];
    public $id_producto;
    public $producto;
    public $cod_producto;
    public $marca;
    public $categoria;
    public $proveedor;
    protected $listeners = ['resetNamesProductos' => 'resetInput','asignProducto' => 'asignProducto','dropByStateProducto' => 'dropByState'];
    protected $rules = [
        'producto' => 'required|min:4|max:100',
        'cod_producto' => 'required|min:4|max:50',
        'categoria' => 'required',
        'marca' => 'required',
        'proveedor' => 'required'
    ];
    protected  $messages = [
        'producto.required' => 'El Nombre es Obligatorio',
        'producto.min' => 'El Nombre debe contener un Mímino de 4 Caracteres',
        'producto.max' => 'El Nombre debe contener un Maximio de 100 Caracteres',
        'cod_producto.required' => 'El Codigo del Producto es Obligatorio',
        'cod_producto.min' => 'El Codigo del Producto debe contener un Mímino de 4 Caracteres',
        'cod_producto.max' => 'El Codigo del Producto debe contener un Maximio de 100 Caracteres',
        'categoria.required' => 'La Categoria es Obligatoria',
        'marca.required' => 'La Marca es Obligatoria',
        'proveedor.required' => 'El Proveedor es Obligatorio'
    ];
    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['producto','cod_producto','id_producto','marca','categoria','proveedor']);
    }
    public function asignProducto($producto)
    {
        $this->id_producto = $producto['id_producto'];
        $this->producto = $producto['producto'];
        $this->cod_producto = $producto['cod_producto'];
        $this->marca = $producto['marca'];        
        $this->categoria = $producto['categoria'];
        $this->proveedor = $producto['proveedor'];
        $this->proveedores = Proveedor::select('id','nombre')->where('estado',1)->get();
        $this->categorias = Categoria::select('id','nombre')->where('estado',1)->get();
        $this->marcas = MarcaModel::select('id','nombre')->where('estado',1)->get();
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }



    public function createProducto()
    {
        $validatedData = $this->validate();
        if ($this->id_producto) {
            try {
                
                
                Producto::where('id',$this->id_producto)->update([
                    'nombre' => $this->producto,
                    'cod_producto' => $this->cod_producto,
                    'id_categoria' => $this->categoria,
                    'id_marca' => $this->marca,
                    'id_proveedor' => $this->proveedor
                ]);
                session(['alert' => ['type' => 'success', 'message' => 'Producto Actualizado con éxito.','position' =>'center']]);
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/productos');
            } catch (\Exception $th) {
                session(['alert' => ['type' => 'error', 'message' => 'Ha Ocurrido un error.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/productos');
            }
        } else {
            try {
                Producto::create([
                    'nombre' => $this->producto,
                    'cod_producto' => $this->cod_producto,
                    'id_categoria' => $this->categoria,
                    'id_marca' => $this->marca,
                    'id_proveedor' => $this->proveedor
                ]);
                session(['alert' => ['type' => 'success', 'message' => 'Producto Guardado con éxito.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/productos');
            } catch (\Exception $th) {
                session(['alert' => ['type' => 'error', 'message' => 'Ha Ocurrido un error.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/productos');
            }
        }
        
    }

    public function dropByState($id)
    {
        try {
            Producto::where('id',$id)->update(['estado' => 0]);               
            session(['alert' => ['type' => 'success', 'message' => 'Producto eliminado con éxito.']]);
            return redirect()->to('/productos');
        } catch (\Exception $th) {
           
            $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                'position' => 'center'
            ]);
        }
    }



    public function render()
    {
        $this->proveedores = Proveedor::select('id','nombre')->where('estado',1)->get();
        $this->categorias = Categoria::select('id','nombre')->where('estado',1)->get();
        $this->marcas = MarcaModel::select('id','nombre')->where('estado',1)->get();
        return view('livewire.productos');
    }
}
