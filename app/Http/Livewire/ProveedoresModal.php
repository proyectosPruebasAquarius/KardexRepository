<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Proveedor;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProveedoresModal extends Component
{

    use LivewireAlert;      
    public $nombre;
    public $direccion;
    public $idDireccion;
    public $title;
    public $web;
    public $encargado;
    public $encargado_tel;
    public $telefono;
    public $codigo;

    protected $listeners = ['resetDataP' => 'resetState', 'assign' => 'assign'];
    
    protected $rules = [
        'nombre' => 'required|min:4',
        'direccion' => 'required|min:6|max:500',
        'telefono' => 'required|min:8|max:10',
        'web' => ['nullable', 'url', 'min:3', 'max:200'],
        'encargado' => ['nullable', 'min:4', 'max:150', 'string'],
        'encargado_tel' => ['nullable', 'regex:^[0-9]{8,}$^'],
        'codigo' => 'nullable|min:2|max:100'
    ];
 
    protected $messages = [    
        'telefono.integer' => 'El campo teléfono debe contener valores numericos.',
        'encargado_tel.regex' => 'El campo teléfono encargado debe contener un número de teléfono valido.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createData() 
    {
        $validatedData = $this->validate();

        if ($this->idDireccion) {
            try {
                $proveedor = Proveedor::findOrFail($this->idDireccion);
                $proveedor->update($validatedData);
                
                /* $this->toastM('success', 'Dato actualizado con éxito.'); */
                session(['alert' => ['type' => 'success', 'message' => 'Dato actualizado con éxito.']]);
                return redirect()->to('/proveedores');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                $this->toastM('error', 'Ocurrió un error porfavor intentelo mas tarde.');
                /* \Debugbar::info($th->getMessage()); */
            }
        } else {
            try {
                Proveedor::create($validatedData);
                session(['alert' => ['type' => 'success', 'message' => 'Dato creado con éxito.']]);
                return redirect()->to('/proveedores');
                /* $this->toastM('success', 'Dato creado con éxito.'); */
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                $this->toastM('error', 'Ocurrió un error porfavor intentelo mas tarde.');
                /* \Debugbar::info($th->getMessage()); */
            }
        }        
    }

    public function toastM($type, $message)
    {
        $this->alert($type, $message, [
            'position' => 'bottom'
        ]);
    }

    public function resetState()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->reset(['idDireccion', 'direccion', 'nombre', 'telefono', 'web', 'encargado_tel', 'encargado', 'codigo']);
    }

    public function assign($e)
    {
        $this->idDireccion = $e['id'];
        $this->nombre = $e['nombre'];
        $this->direccion = $e['direccion'];
        $this->telefono = $e['telefono'];
        $this->web = $e['web'];
        $this->encargado_tel = $e['encargado_tel'];
        $this->encargado = $e['encargado'];
        $this->codigo = $e['codigo'];
    }

    public function render()
    {
        return view('livewire.proveedores-modal');
    }
}
