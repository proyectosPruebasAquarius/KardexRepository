<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Aside extends Component
{
    public function asideToggle()
    {
        if(request()->session()->has('expandedSide')) 
        {            
            if (session('expandedSide')) {
                request()->session()->forget('expandedSide');
            } else {
                session(['expandedSide' => true]);
            }

        } else {
            session(['expandedSide' => true]);
        }
    }

    public function render()
    {
        return view('livewire.aside');
    }
}
