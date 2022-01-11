<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Hash;
use App\User; 

class UsersUpdate extends Component
{

    use LivewireAlert;

    public $name;
    public $email;
    public $password;
    public $idUser;

    protected $listeners = ['resetUserModalU' => 'resetState', 'assignUser' => 'assign'];

    protected $rules = [
        'name' => 'required|min:4|max:255|string',
        'email' => 'required|email|min:6|max:255|string',
        'password' => 'nullable|min:6',
        'idUser' => 'required|integer'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createData()
    {
        $validatedData = $this->validate();

        $validatedData['password'] = empty($validatedData['password']) ? User::where('id', $this->idUser)->value('password') : Hash::make($validatedData['password']);
        
            try {
                $user = User::findOrFail($this->idUser);
                $user->update($validatedData);
                /* $this->emitSelf('listReload'); */
                session(['alert' => ['type' => 'success', 'message' => 'Dato actualizado con éxito.']]);
                return redirect()->to('/usuarios');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                \Debugbar::info($th->getMessage());
                $this->alert('error', 'Ocurrió un error porfavor intentelo mas tarde.', [
                    'position' => 'bottom'
                ]);
            }
        
    }

    public function resetState()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->reset(['name', 'email', 'password', 'idUser']);
    }

    public function assign($e)
    {
        $this->idUser = $e['id'];
        $this->name = $e['name'];
        $this->email = $e['email'];
    }

    public function render()
    {
        return view('livewire.users-update');
    }
}
