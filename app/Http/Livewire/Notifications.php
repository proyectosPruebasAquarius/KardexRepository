<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User; 

class Notifications extends Component
{    
    public $notifications = array();

    protected $listeners = ['reloadN' => '$refresh'];

    public function redirection($id)
    {       
        \DB::table('notifications')->where([['id', $id], ['notifiable_id', auth()->user()->id]])->update(['read_at' => now()]);
        return redirect()->to('/inventarios');

    }

    public function render()
    {
        if (auth()->check()) {
            $this->notifications = auth()->user()->unreadNotifications;
        }
        return view('livewire.notifications');
    }
}
