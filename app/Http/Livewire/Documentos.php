<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\TipoDocumento;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class Documentos extends Component
{
    use LivewireAlert;
    public $nombre;
    public $id_tipo;
    protected $listeners = ['resetNamesTipo' => 'resetInput','asignTipo' => 'asignTipo','dropByStateTipo' => 'dropByState'];
    protected $rules = [
        'nombre' => 'required|min:4|max:150',
        
    ];
    protected $messages =[
        'nombre.required' => 'El Nombre  es Obligatorio',
        'nombre.min' => 'El Nombre  debe contener un mínimo de :min caracteres',
        'nombre.max' => 'El Nombre  debe contener un máximo de :max caracteres'
    ];

    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['nombre','id_tipo']);
    }

    public function asignTipo($tipo)
    {
        $this->id_tipo = $tipo['id'];
        $this->nombre = $tipo['nombre'];
    }
 
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createData() 
    {
        $validatedData = $this->validate();
        if ($this->id_tipo ) {
            try {
                TipoDocumento::where(['id' => $this->id_tipo])->update($validatedData);
                session(['alert' => ['type' => 'success', 'message' => 'Tipo de Documento Actualizado con éxito.','position' =>'center']]);
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/tipos-documentos');
            } catch (\Exception $th) {
                session(['alert' => ['type' => 'error', 'message' => 'Ha Ocurrido un error.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/tipos-documentos');
            }
        }else {
            try {
                TipoDocumento::create($validatedData);
                session(['alert' => ['type' => 'success', 'message' => 'Tipo de Documento Guardado con éxito.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/tipos-documentos');
            } catch (\Exception $th) {
                session(['alert' => ['type' => 'error', 'message' => 'Ha Ocurrido un error.','position' =>'center']]);               
                $this->dispatchBrowserEvent('closeModal'); 
                return redirect()->to('/tipos-documentos');
            }
        }
       
    }


    public function dropByState($id)
    {
        try {
            TipoDocumento::where('id',$id)->update(['estado' => 0]);               
            session(['alert' => ['type' => 'success', 'message' => 'Tipo de Documento eliminado con éxito.']]);
            return redirect()->to('/tipos-documentos');
        } catch (\Exception $th) {
           
            $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                'position' => 'center'
            ]);
        }
    }




    public function render()
    {
        return view('livewire.documentos');
    }
}
