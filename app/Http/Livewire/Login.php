<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class Login extends Component
{
    public $email;
    public $password;
    public $checked;
    
    protected $rules = [
        'password' => 'required|min:6',
        'email' => 'required|email|string',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function login()
    {        
        $validatedData = $this->validate();

        if (Auth::attempt($validatedData)) {
            // Authentication passed...
            return redirect()->intended('/');
        } else {
            $this->addError('email', 'Email o contraseña erroneos.');
            $this->addError('password', 'Email o contraseña erroneos.');
        }
    }   

    public function render()
    {        
        return view('livewire.login');
    }
}
