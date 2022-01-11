<?php

namespace App\Http\Livewire;

use App\DetalleInventariosModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DetalleInventarios extends Component
{
    use LivewireAlert;
    public $inventarios = [];
    public $id_inventario;
    public $concepto;
    public $cantidad_saldo;
    public $cantidad_entrada;
    public $cantidad_salida;
    public $precio_unitario;
    public $total_saldo;
    public $total_entrada;
    public $total_salida;
    public $fecha_registro;

    protected $listeners = ['resetNamesDetalleInventarios' => 'resetInput', 'asignDetalleInventario' => 'asignDetalleInventario'];

    protected $rules = [
        'concepto' => 'required|min:5|max:150',
        'precio_unitario' => ['required', 'regex:/^(?:[1-9]\d+|\d)(?:\.\d\d)?$/'],
        'fecha_registro' => 'required|date',

    ];
    protected $messages = [
        'concepto.required' => 'El Concepto es Obligatorio',
        'concepto.min' => 'Debe contener al menos :min caracteres',
        'concepto.max' => 'Debe contener un maximo :max caracteres',
        'precio_unitario.required' => 'El Precio Unitario es Obligarorio',
        'precio_unitario.regex' => 'Formato No Valido',
        'fecha_registro.required' => 'La Fecha es Obligatoria',
        'fecha_registro.date' => 'Formato no Valido',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function asignDetalleInventario($inventario)
    {
        $this->id_inventario = $inventario['id_inventario'];

    }
    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['id_inventario', 'concepto', 'precio_unitario', 'cantidad_entrada', 'cantidad_salida', 'fecha_registro']);
    }

    public function createDetalleInventario()
    {
        $this->validate();
        try {

            $saveDetalle = new DetalleInventariosModel;
            $lastInsert = DetalleInventariosModel::select('cantidad_saldo','total_saldo')->orderBy('id','DESC')->get();
            
            if ($this->cantidad_entrada == null && $this->cantidad_salida == null) {
                $this->dispatchBrowserEvent('closeModal');
                $this->alert('error', 'Debes Introducir una cantidad, ya sea de entrada o salida', [
                    'position' => 'center',
                    'timer' => 2000,
                ]);
            } else {
                $saveDetalle->id_inventario = $this->id_inventario;
                $saveDetalle->concepto = $this->concepto;
                $saveDetalle->fecha_registro = $this->fecha_registro;
                $saveDetalle->precio_unitario = $this->precio_unitario;

                if ($this->cantidad_entrada !== null && $this->cantidad_salida !== null) {
                    $this->dispatchBrowserEvent('closeModal');
                    $this->alert('error', 'No Puedes ingresar una Entrada y Salida a la vez', [
                        'position' => 'center',
                        'timer' => 5000,
                    ]);
                }

                if (sizeof($lastInsert) == 0 && $this->cantidad_salida !== null ) {
                    $this->dispatchBrowserEvent('closeModal');
                    $this->alert('error', 'No Puedes ingresar Salida. Por que este Inventario todavia no tiene ninguna Entrada', [
                        'position' => 'center',
                        'timer' => 5000,
                    ]);
                }

                if ($this->cantidad_entrada !== null && sizeof($lastInsert) == 0) {
                    $saveDetalle->cantidad_entrada = $this->cantidad_entrada;
                    $saveDetalle->total_entrada = $this->precio_unitario * $this->cantidad_entrada;
                    $saveDetalle->total_saldo = $this->precio_unitario * $this->cantidad_entrada;
                    $saveDetalle->cantidad_saldo = $this->cantidad_entrada;
                }else {
                    if ($this->cantidad_entrada !== null) {
                        $saveDetalle->cantidad_entrada = $this->cantidad_entrada;
                        $saveDetalle->cantidad_saldo = $lastInsert[0]->cantidad_saldo + $this->cantidad_entrada;
                        $saveDetalle->total_entrada = $this->precio_unitario * $this->cantidad_entrada;
                        $saveDetalle->total_saldo =  $lastInsert[0]->total_saldo + $this->precio_unitario * $this->cantidad_entrada;
                    }else {
                        $saveDetalle->cantidad_salida = $this->cantidad_salida;
                        $saveDetalle->cantidad_saldo = $lastInsert[0]->cantidad_saldo - $this->cantidad_salida;
                        $saveDetalle->total_salida = $this->precio_unitario * $this->cantidad_salida;
                        $saveDetalle->total_saldo =  $lastInsert[0]->total_saldo - $this->precio_unitario * $this->cantidad_salida;
                    }
                }    
                
                $saveDetalle->save();


                session(['alert' => ['type' => 'success', 'message' => 'Inventario Guardado con éxito.','position' =>'center']]);
                $this->dispatchBrowserEvent('closeModal');
                return redirect()->to('/inventarios');
            }
                   
        } catch (\Exception $th) {
            session(['alert' => ['type' => 'error', 'message' => $th->getMessage(), 'position' => 'center']]);
            $this->dispatchBrowserEvent('closeModal');
            return redirect()->to('/inventarios');
        }

    }

    public function render()
    {

        return view('livewire.detalle-inventarios');
    }
}
