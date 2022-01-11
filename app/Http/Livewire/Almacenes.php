<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Almacen;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Almacenes extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $headers = array();
    public $data = array();
    public $model;
    public $search;
    public $nombre;
    public $direccion;
    public $idDireccion;
    public $title;

    protected $listeners = ['listReload' => '$refresh', 'resetData' => 'resetState', 'dropByState' => 'dropByState', 'assignAl' => 'assign'];
    protected $queryString = ['search'];
    protected $rules = [
        'nombre' => 'required|min:4|max:100',
        'direccion' => 'required|min:6|max:500',
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
                $almacen = Almacen::findOrFail($this->idDireccion);
                $almacen->update($validatedData);
                /* $this->emitSelf('listReload'); */
                session(['alert' => ['type' => 'success', 'message' => 'Dato actualizado con éxito.']]);
                return redirect()->to('/almacenes');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                \Debugbar::info($th->getMessage());
                $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                    'position' => 'bottom'
                ]);
            }
        } else {
            try {
                Almacen::create($validatedData);
                /* $this->emitSelf('listReload'); */
                session(['alert' => ['type' => 'success', 'message' => 'Dato creado con éxito.']]);
                return redirect()->to('/almacenes');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                \Debugbar::info($th->getMessage());
                $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                    'position' => 'bottom'
                ]);
            }
        }        
    }

    public function resetState()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->reset(['idDireccion', 'direccion', 'nombre']);
    }

    public function assign($e)
    {
        $this->idDireccion = $e['id'];
        $this->nombre = $e['nombre'];
        $this->direccion = $e['direccion'];
    }

    public function dropByState($id)
    {
        try {
            $almacen = Almacen::findOrFail($id);
            $almacen->update(['estado' => 0]);
            /* \Debugbar::info($id); */
            /* $this->emitSelf('listReload'); */
            session(['alert' => ['type' => 'success', 'message' => 'Dato eliminado con éxito.']]);
            return redirect()->to('/almacenes');
        } catch (\Exception $th) {
            //throw $th;
            $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                'position' => 'bottom'
            ]);
        }
    }

    /* public function mount()
    {
        $this->headers = explode(', ', $this->headers);
    }  */

    public function render()
    {
        /* $this->title = $this->idDireccion ? 'Actualizar' : 'Agregar';
        $model = $this->model;
        $headers = $this->headers;
        $search = '%'.$this->search.'%';
        $this->data = $model::when($this->search, function ($query) use($search, $headers) {
            
            foreach ($headers as $key => $value) {
                $query->where($value, 'like', $search);
            }

        })->where('estado', 1)->orderBy('nombre', 'asc')->get();  */
        return view('livewire.almacenes');
    }
}
