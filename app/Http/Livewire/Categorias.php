<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Categoria;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Categorias extends Component
{
    use LivewireAlert;
    public $nombre;
   
    public $id_categoria;
    public $categorias = [];
    protected $listeners = ['listReloadCategoria' => '$refresh','resetNamesCat' => 'resetInput','asignCategoria' =>'asignCategoria','dropByStateCategoria' => 'dropByState'];
    protected $rules = [
        'nombre' => 'required|min:4|max:100',
        
    ];
    protected $messages =[
        'nombre.required' => 'El Nombre es Obligatorio',
        'nombre.min' => 'El Nombre debe contener un mínimo de 4 caracteres',
        'nombre.max' => 'El Nombre debe contener un máximo de 100 caracteres'
    ];


    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['nombre','id_categoria']);
    }

    public function asignCategoria($categoria)
    {
        $this->id_categoria = $categoria['id'];
        $this->nombre = $categoria['nombre'];
    }
 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createCategoria()
    {
      
       if ($this->id_categoria) {
           try {
            Categoria::where('id',$this->id_categoria)->update([
                'nombre' => $this->nombre
            ]);          
            session(['alert' => ['type' => 'success', 'message' => 'Categoria Actualizada con éxito.','position' =>'center']]);
            return redirect()->to('/categorias');
            $this->dispatchBrowserEvent('closeModal'); 
           } catch (\Exception $th) {
            $this->dispatchBrowserEvent('closeModal'); 
            session(['alert' => ['type' => 'error', 'message' => 'Ocurrio un Error.','position' =>'center']]);
            return redirect()->to('/categorias');
           }
       } else {
            try {
                Categoria::create([
                    'nombre' => $this->nombre
                ]);                                
                $this->dispatchBrowserEvent('closeModal'); 
                session(['alert' => ['type' => 'success', 'message' => 'Categoria Guardada con éxito.','position' =>'center']]);
                return redirect()->to('/categorias');
            } catch (\Exception $th) {
                $this->dispatchBrowserEvent('closeModal'); 
                session(['alert' => ['type' => 'error', 'message' => 'Ocurrio un Error.','position' =>'center']]);
                return redirect()->to('/categorias');
            }
       }
       
    }
    public function dropByState($id)
    {
        try {
            Categoria::where('id',$id)->update(['estado' => 0]);               
            session(['alert' => ['type' => 'success', 'message' => 'Categoria eliminada con éxito.']]);
            return redirect()->to('/categorias');
        } catch (\Exception $th) {
           
            $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                'position' => 'center'
            ]);
        }
    }

    public function render()
    {
        
        return view('livewire.categorias');
    }
}
