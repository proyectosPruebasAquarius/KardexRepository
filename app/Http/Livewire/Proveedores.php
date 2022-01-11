<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Proveedor;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Proveedores extends Component
{   
    use LivewireAlert;
    public $data = array();    
    public $nombre;
    public $direccion;
    public $idDireccion;
    public $title;
    public $telefono;

    protected $listeners = ['listReloadP' => '$refresh', 'dropByStateP' => 'dropByState'];
    
    protected $rules = [
        'nombre' => 'required|min:4',
        'direccion' => 'required|min:6|max:500',
        'telefono' => 'required|min:8|max:10|integer'
    ];
 
    protected $messages = [    
        'telefono.integer' => 'El campo teléfono debe contener valores numericos.',
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
                $this->emitSelf('listReloadP');
                $this->toastM('success', 'Dato actualizado con éxito.');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                $this->toastM('error', 'Ocurrió un error porfavor intentelo mas tarde.');
                \Debugbar::info($th->getMessage());
            }
        } else {
            try {
                Proveedor::create($validatedData);
                $this->emitSelf('listReloadP');
                $this->toastM('success', 'Dato creado con éxito.');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                $this->toastM('error', 'Ocurrió un error porfavor intentelo mas tarde.');
                \Debugbar::info($th->getMessage());
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

        $this->reset(['idDireccion', 'direccion', 'nombre', 'telefono']);
    }

    public function assign($e)
    {
        $this->idDireccion = $e['id'];
        $this->nombre = $e['nombre'];
        $this->direccion = $e['direccion'];
        $this->telefono = $e['telefono'];
    }

    public function dropByState($id)
    {
        try {
            $proveedor = Proveedor::findOrFail($id);
            $proveedor->update(['estado' => 0]);
            /* \Debugbar::info($id); */
            session(['alert' => ['type' => 'success', 'message' => 'Dato eliminado con éxito.']]);
            return redirect()->to('/proveedores');
        } catch (\Exception $th) {
            //throw $th;
            $this->toastM('error', 'Ocurrió un error porfavor intentelo mas tarde.');
        }
    }    

    public function render()
    {
        $this->data = Proveedor::where('estado', 1)->get();
        return view('livewire.proveedores');
    }
}
