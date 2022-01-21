<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Tienda;
use App\Almacen;

class Tiendas extends Component
{
    use LivewireAlert;      
    public $nombre;
    public $direccion;
    public $idDireccion;
    public $id_almacen;
    public $almacen;
    public $title;
    public $almacenes = array();
    public $codigo;

    protected $listeners = ['resetDataTi' => 'resetState', 'assignTi' => 'assign', 'assignAlmacen' => 'assignAlmacen', 'deleteTienda' => 'trash'];
    
    protected $rules = [
        'nombre' => 'required|min:4',
        'direccion' => 'required|min:6|max:500',
        'codigo' => 'nullable|min:3|max:100',
        'id_almacen' => 'required'        
        /* 'idDireccion' => 'required' */
    ];   

    protected $messages = [
        'id_almacen.required' => 'El campo almacen es requerido.'
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedIdAlmacen()
    {
        $this->dispatchBrowserEvent('showDropdown');
        
    }

    public function createData() 
    {
        $validatedData = $this->validate();

        if ($this->idDireccion) {
            try {
                $tienda = Tienda::findOrFail($this->idDireccion);
                $tienda->update($validatedData);
                
                /* $this->toastM('success', 'Dato actualizado con éxito.'); */
                session(['alert' => ['type' => 'success', 'message' => 'Dato actualizado con éxito.']]);
                return redirect()->to('/tiendas');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                $this->toastM('error', 'Ocurrió un error porfavor intentelo mas tarde.');
                
            }
        } else {
            try {
                Tienda::create($validatedData);
                session(['alert' => ['type' => 'success', 'message' => 'Dato creado con éxito.']]);
                return redirect()->to('/tiendas');
                /* $this->toastM('success', 'Dato creado con éxito.'); */
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                $this->toastM('error', 'Ocurrió un error porfavor intentelo mas tarde.');
                
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

        $this->reset(['idDireccion', 'direccion', 'nombre', 'id_almacen', 'codigo']);
    }

    public function assign($e)
    {
        $this->idDireccion = $e['id'];
        $this->nombre = $e['nombre'];
        $this->direccion = $e['direccion'];
        $this->id_almacen = $e['id_almacen'];
        $this->codigo = $e['codigo'];
    }

    public function assignAlmacen($a)
    {
        $this->fill(['id_almacen' => $a]);
        
    } 

    public function trash($id) 
    {
        try {
            $tienda = Tienda::findOrFail($id);
            $tienda->update(['estado' => 0]);           
            session(['alert' => ['type' => 'success', 'message' => 'Dato eliminado con éxito.']]);
            return redirect()->to('/tiendas');
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
        $this->almacenes = Almacen::where('estado', 1)->select('id as value', 'nombre as label')->get();
        return view('livewire.tiendas');
    }
}
