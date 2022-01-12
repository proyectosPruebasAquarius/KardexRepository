<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    use LivewireAlert;

    public $name;
    public $email;
    public $password;
    public $idUser;

    protected $listeners = ['resetUserModal' => 'resetState','trashUser' => 'trash'/* , 'assignUser' => 'assign' */];

    protected $rules = [
        'name' => 'required|min:4|max:255|string',
        'email' => 'required|email|min:6|max:255|unique:users|string',
        'password' => 'required|min:6'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createData()
    {
        $validatedData = $this->validate();

        $validatedData['password'] = Hash::make($validatedData['password']);
        if ($this->idUser) {
            try {
                $user = User::findOrFail($this->idDireccion);
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
        } else {
            try {
                User::create($validatedData);
                /* $this->emitSelf('listReload'); */
                session(['alert' => ['type' => 'success', 'message' => 'Dato creado con éxito.']]);
                return redirect()->to('/usuarios');
            } catch (\Exception $th) {
                //ocurrio un error inesperado
                \Debugbar::info($th->getMessage());
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

        $this->reset(['name', 'email', 'password', 'idUser']);
    }

    public function assign($e)
    {
        $this->idUser = $e['id'];
        $this->name = $e['name'];
        $this->email = $e['email'];
    }
    public function trash($id)
    {
        User::findOrFail($id)->delete();
        session(['alert' => ['type' => 'success', 'message' => 'Usuario eliminado con éxito.']]);
        return redirect()->to('/usuarios');
    }

    public function render()
    {
        return view('livewire.users');
    }
}
