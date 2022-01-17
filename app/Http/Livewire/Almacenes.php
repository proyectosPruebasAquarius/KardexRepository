<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Almacen;
use App\AlmacenZona;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
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
    public $zonas = array();
    public $zona;
    public $focused = false;

    protected $listeners = ['listReload' => '$refresh', 'resetData' => 'resetState', 'dropByState' => 'dropByState', 'assignAl' => 'assign'];
    protected $queryString = ['search'];
    protected $rules = [
        'nombre' => 'required|min:4|max:100',
        'zonas' => 'nullable|array'
        /* 'direccion' => 'required|min:6|max:500', */
    ];
 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedZona() {
        /* $this->zonas = explode(',', $this->zona);
        
        /* \Debugbar::info($this->focused); */
    }

    public function createData() 
    {
        $validatedData = $this->validate();
        $this->zonas = !empty($this->zonas) ? array_merge($this->zonas, explode(',', $this->zona)) : explode(',', $this->zona);

        if ($this->idDireccion) {
            try {
                DB::beginTransaction();
                $almacen = Almacen::findOrFail($this->idDireccion);
                $almacen->update($validatedData);
                /* $this->emitSelf('listReload'); */
                if (!empty($this->zonas)) {
                    foreach ($this->zonas as $z) {
                        if (!empty($z['id'])) {
                            $model = AlmacenZona::findOrFail($z['id']);
                            $model->update([
                                'nombre' => $z['nombre']
                            ]); 
                        } else {
                            if (!empty($z)) {
                                $zona = new AlmacenZona;
                                $zona->nombre = $z;
                                $zona->estado = 1;
                                $zona->id_almacen = $this->idDireccion;
                                $zona->save();
                            }
                        }
                    }
                }
                DB::commit();
                session(['alert' => ['type' => 'success', 'message' => 'Dato actualizado con éxito.']]);
                return redirect()->to('/almacenes');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                
                DB::rollBack();
                $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                    'position' => 'bottom'
                ]);
            }
        } else {
            try {
                DB::beginTransaction();
                $almacenado = Almacen::create($validatedData);
                
                if (!empty($this->zonas)) {
                    foreach ($this->zonas as $z) {
                        if (!empty($z)) {
                            /* AlmacenZona::create([
                                'nombre' => $z,
                                'estado' => 1,
                                'id_almacen' => $almacenado->id
                            ]); */
                            $zona = new AlmacenZona;
                            $zona->nombre = $z;
                            $zona->estado = 1;
                            $zona->id_almacen = $almacenado->id;
                            $zona->save();
                        }
                    }
                }
                /* $this->emitSelf('listReload'); */
                DB::commit();
                session(['alert' => ['type' => 'success', 'message' => 'Dato creado con éxito.']]);
                return redirect()->to('/almacenes');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                
                DB::rollBack();
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

        $this->reset(['idDireccion', 'direccion', 'nombre', 'zonas', 'zona', 'focused']);
    }

    public function assign($e, $z)
    {
        $this->idDireccion = $e['id'];
        $this->nombre = $e['nombre'];
        $this->zonas = $z;
        /* $this->zona = $z; */
        
        /* $this->direccion = $e['direccion']; */
    }

    public function dropByState($id)
    {
        try {
            $corroborate = \DB::table('tiendas')->where([['id_almacen', $id], ['estado', 1]])->count();
            $corroborateTwo = \DB::table('almacenes_zonas')->where([['id_almacen', $id], ['estado', 1]])->count();

            if ($corroborate == 0 && $corroborateTwo == 0) {
                $almacen = Almacen::findOrFail($id);
                $almacen->update(['estado' => 0]);
                
                /* $this->emitSelf('listReload'); */
                session(['alert' => ['type' => 'success', 'message' => 'Dato eliminado con éxito.']]);
                return redirect()->to('/almacenes');
            } else {
                session(['alert' => ['type' => 'info', 'message' => 'Elimina las tiendas o zonas relacionadas a este almacen, para poder eliminarlo.']]);
                return redirect()->to('/almacenes');
            }
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
