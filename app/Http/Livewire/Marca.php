<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\MarcaModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Marca extends Component
{
    use LivewireAlert;
    public $nombre;
    public $error;
    public $id_marca;
    public $marcas =[];
    protected $listeners = ['listReload' => '$refresh','resetNames' => 'resetInput','asignMarca' => 'asignMarca','dropByStateMarca' => 'dropByState'];
    protected $rules = [
        'nombre' => 'required|min:4|max:100',
        
    ];
    protected $messages =[
        'nombre.required' => 'El Nombre de la Marca es Obligatorio',
        'nombre.min' => 'El Nombre de la Marca debe contener un mínimo de 4 caracteres',
        'nombre.max' => 'El Nombre de la Marca debe contener un máximo de 100 caracteres'
    ];

    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['nombre','id_marca']);
    }

    public function asignMarca($var)
    {
        $this->id_marca = $var['id'];
        $this->nombre = $var['nombre'];
    }
 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createData() 
    {
        $validatedData = $this->validate();
        if ($this->id_marca ) {
            try {
                $marca = MarcaModel::findOrFail($this->id_marca);
                
                $marca->update($validatedData);
                session(['alert' => ['type' => 'success', 'message' => 'Marca Actualizada con éxito.','position' =>'center']]);
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/marcas');
            } catch (\Exception $th) {
                session(['alert' => ['type' => 'error', 'message' => 'Ha Ocurrido un error.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/marcas');
            }
        }else {
            try {
                MarcaModel::create($validatedData);
                session(['alert' => ['type' => 'success', 'message' => 'Marca Guardada con éxito.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/marcas');
            } catch (\Exception $th) {
                session(['alert' => ['type' => 'error', 'message' => 'Ha Ocurrido un error.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/marcas');
            }
        }
       
    }


    public function dropByState($id)
    {
        try {
            MarcaModel::where('id',$id)->update(['estado' => 0]);               
            session(['alert' => ['type' => 'success', 'message' => 'Marca eliminada con éxito.']]);
            return redirect()->to('/marcas');
        } catch (\Exception $th) {
           
            $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                'position' => 'center'
            ]);
        }
    }


    public function render()
    {
        
        return view('livewire.marca');
    }
}
