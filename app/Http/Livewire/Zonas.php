<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\AlmacenZona;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Zonas extends Component
{
    public $nombre;    
    public $idZona;
    public $focused = false;

    protected $listeners = ['resetDataZ' => 'resetState', 'assignZonas' => 'assign'];

    protected $rules = [
        'nombre' => 'required|min:4'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    
    public function createData() 
    {
        $validatedData = $this->validate();

        if ($this->idZona) {
            try {
                $zona = AlmacenZona::findOrFail($this->idZona);
                $zona->nombre = $validatedData['nombre'];
                $zona->update();
                
                
                session(['alert' => ['type' => 'success', 'message' => 'Dato actualizado con éxito.']]);
                return redirect()->to('/almacenes');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                $this->toastM('error', 'Ocurrió un error porfavor intentelo mas tarde.');
                
            }
        } /* else {
            try {
                AlmacenZona::create($validatedData);
                session(['alert' => ['type' => 'success', 'message' => 'Dato creado con éxito.']]);
                return redirect()->to('/almacenes');
                
            } catch (\Exception $th) {
                
                $this->toastM('error', 'Ocurrió un error porfavor intentelo mas tarde.');
                \Debugbar::info($th->getMessage());
            }
        }      */   
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

        $this->reset(['idZona', 'nombre']);
    }

    public function assign($e)
    {
        $this->idZona = $e['id'];
        $this->nombre = $e['nombre'];
    }


    public function trash () 
    {
        try {
            $almacen = AlmacenZona::findOrFail($this->idZona);
            $almacen->update(['estado' => 0]);           
            session(['alert' => ['type' => 'success', 'message' => 'Dato eliminado con éxito.']]);
            return redirect()->to('/almacenes');
        } catch (\Exception $th) {
            //throw $th;
            $this->dispatchBrowserEvent('close-modal');
            $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                'position' => 'bottom'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.zonas');
    }
}
