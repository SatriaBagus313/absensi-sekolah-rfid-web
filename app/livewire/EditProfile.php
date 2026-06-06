<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class EditProfile extends Component
{
    public $name, $email, $current_password, $new_password;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        $user = auth()->user();

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6',
        ]);

        if ($this->new_password) {
            if (!Hash::check($this->current_password, $user->password)) {
                session()->flash('error', 'Password lama tidak cocok!');
                return;
            }
            $user->password = Hash::make($this->new_password);
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        session()->flash('message', 'Profil Anda berhasil diperbarui!');
        $this->current_password = '';
        $this->new_password = '';
    }

public function render()
    {
        return view('livewire.edit-profile');
    }
}