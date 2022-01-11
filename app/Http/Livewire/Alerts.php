<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Alerts extends Component
{
    use LivewireAlert;
    protected $listeners = ['showAlerts' => 'showAlert'];

    public function showAlert($type, $message)
    {
        \Debugbar::info($type, $message);
        $this->alert($type, $message, [
            'position' => 'bottom'
        ]);
    }

    public function render()
    {
        return view('livewire.alerts');
    }
}
