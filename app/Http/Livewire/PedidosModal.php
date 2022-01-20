<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Pedido;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Route;

class PedidosModal extends Component
{
    use LivewireAlert;
    public $precio;
    public $cantidad;
    public $id_pedido;
    public $producto;
    public $proveedor;
    public $proveedor_tel;
    public $cod_producto;
    public $estado = 1;
    public $currentUrl;
    public $isState = false;    

    protected $listeners = ['resetVFPedidos' => 'resetValidationAndInputs', 'assignValuePedidos' => 'assignValues', 'destroyPdido' => 'trash', 'edidStateM' => 'edidState', 'notifyId' => 'notifyId'];

    protected $rules = [
        'precio' => ['required', 'numeric'],
        'cantidad' => ['required', 'numeric'],
        'id_pedido' => 'required',
        'producto' => 'required'
    ];

    protected $messages = [
        'precio.numeric' => 'El campo precio debe ser de tipo númerico.',
        'cantidad.numeric' => 'El campo precio debe ser de tipo númerico.'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createElement()
    {
        $validation = $this->validate();

        if ($this->id_pedido) {
            try {
                $pedido = Pedido::findOrFail($this->id_pedido);
                $pedido->cantidad = $validation['cantidad'];
                $pedido->precio = $validation['precio'];
                $pedido->estado = $this->estado;
                $pedido->update();

                if ($this->currentUrl === 'pedidos') {
                    session(['alert' => ['type' => 'success', 'message' => 'Pedido almacenado con éxito.','position' =>'center']]);
                    return redirect(request()->header('Referer'));
                } else {                   
                    $this->dispatchBrowserEvent('closeModal');
                    $this->alert('success', 'Pedido almacenado con éxito.', [
                        'position' => 'center',
                        'timer' => 3000,
                    ]);
                }
                
                
            } catch (\Exception $th) {
                $this->dispatchBrowserEvent('closeModal');
                $this->alert('error', $th->getMessage(), [
                    'position' => 'center',
                    'timer' => 3000,
                ]);
            }
        }
    }

    public function resetValidationAndInputs()
    {
        $this->resetErrorBag();

        $this->resetValidation();
        $this->reset(['precio', 'cantidad', 'id_pedido', 'producto', 'isState']);
    }

    public function assignValues($id)
    {
        $value = Pedido::join('productos', 'pedidos_productos.id_producto', '=', 'productos.id')->join('proveedores', 'productos.id_proveedor', '=', 'proveedores.id')
        ->where('pedidos_productos.id', $id)->select('productos.nombre', 'productos.cod_producto', 'pedidos_productos.*', 'proveedores.nombre as proveedor', 'proveedores.telefono')->first();
        /* \Debugbar::info($id); */
        $this->producto = $value->nombre;
        $this->id_pedido = $value->id;
        $this->proveedor = $value->proveedor;
        $this->proveedor_tel = $value->telefono;
        $this->cod_producto = $value->cod_producto;
        $this->precio = $value->precio;
        $this->cantidad = $value->cantidad;
        if ($this->isState) {
            $this->estado = $value->estado;
        } elseif ($value->estado > 0) {
            $this->estado = $value->estado;
        }else {
            $this->estado = 1;
        }
    }

    public function edidState($id, $state) 
    {
        $this->isState = $state;
        $this->assignValues($id);         
    }

    public function trash($id)
    {
        try {
            Pedido::findOrFail($id)->delete();
            /* $this->alert('success', 'Pedido eliminado con éxito.', [
                'position' => 'center',
                'timer' => 3000,
            ]); */
            session(['alert' => ['type' => 'success', 'message' => 'Pedido eliminado con éxito.','position' =>'center']]);
            return redirect()->to('/pedidos');
        } catch (\Exception $th) {
            $this->alert('error', $th->getMessage(), [
                'position' => 'center',
                'timer' => 3000,
            ]);
        }
    }
    
    public function notifyId($id)
    {
        \DB::table('notifications')->where('id', $id)->update(['read_at' => now()]);
        $this->emit('reloadN');
    }

    public function mount()
    {
        $this->currentUrl = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.pedidos-modal');
    }
}
