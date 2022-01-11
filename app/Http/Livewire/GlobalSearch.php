<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User; 
use App\Almacen;

class GlobalSearch extends Component
{
    public $users = array();
    public $proveedores = array();
    public $almacenes = array();
    public $words = ['usuarios:', 'almacenes:'];
    public $isKeyWord = false;
    public $keyWord;
    public $search; 

    /* protected $queryString = ['isKeyWord']; */

    public function updateProperty()
    {
        \Debugbar::info("updateProperty");
    }

    public function render()
    {
        if (in_array(strtolower($this->search), $this->words)) {
            $this->isKeyWord = true;
            $this->keyWord = $this->search;
            $this->reset('search');            
        } 
        
        if ($this->isKeyWord) {
            switch ($this->keyWord) {
                case 'almacenes:':
                    $this->almacenes = Almacen::where('nombre', 'like', '%'.$this->search.'%')->orWhere('direccion', 'like', '%'.$this->search.'%')->get(['id', 'nombre', 'direccion']);
                    break;
                
                default:
                $this->users = User::where('name', 'like', '%'.$this->search.'%')->orWhere('email', 'like', '%'.$this->search.'%')->get(['id', 'name', 'email']);
                    break;
            }
        } else {
            $this->users = User::where('name', 'like', '%'.$this->search.'%')->orWhere('email', 'like', '%'.$this->search.'%')->get(['id', 'name', 'email']);
            $this->almacenes = Almacen::where('nombre', 'like', '%'.$this->search.'%')->orWhere('direccion', 'like', '%'.$this->search.'%')->get(['id', 'nombre', 'direccion']);
        }
        return view('livewire.global-search');
    }
}
