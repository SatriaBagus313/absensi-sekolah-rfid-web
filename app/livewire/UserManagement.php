<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

class UserManagement extends Component
{
    // PERBAIKAN 1: Mengubah $name menjadi $nama agar sinkron di seluruh fungsi dan blade
    public $users, $nama, $email, $password, $role, $userId;
    public $isEditMode = false;

    // PERBAIKAN 2: Validasi disesuaikan menggunakan properti 'nama'
    protected $rules = [
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:user,email', 
        'role' => 'required|in:admin,superadmin',
        'password' => 'required|min:6',
    ];

    public function render()
    {
        // Mengambil semua data dari tabel user di database db_almagfiroh
        $this->users = \App\Models\User::all();

        // Tetap menggunakan metode extends karena terbukti sukses menembus layout dashboard kamu
        return view('livewire.user-management')
                ->extends('layouts.app') 
                ->section('content');
    }

    public function resetFields()
    {
        // PERBAIKAN 3: Reset disesuaikan ke $this->nama
        $this->nama = '';
        $this->email = '';
        $this->password = '';
        $this->role = '';
        $this->userId = null;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();

        // SINKRON: Kolom 'nama' di database diisi dengan properti '$this->nama' yang sudah terdaftar
        \App\Models\User::create([
            'nama'     => $this->nama, 
            'email'    => $this->email,
            'role'     => $this->role,
            'password' => \Illuminate\Support\Facades\Hash::make($this->password ?? 'password123'),
            'status'   => 'aktif',
        ]);

        $this->resetFields(); 
        session()->flash('message', 'User baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        
        // PERBAIKAN 4: Mengambil data dari kolom 'nama' di database
        $this->nama = $user->nama; 
        $this->email = $user->email;
        $this->role = $user->role;
        $this->isEditMode = true;
    }

    public function update()
    {
        // PERBAIKAN 5: Validasi update disesuaikan ke 'nama' dan tabel 'user'
        $this->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $this->userId,
            'role' => 'required|in:admin,superadmin',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($this->userId);
        
        // PERBAIKAN 6: Mapping data update diarahkan ke kolom 'nama'
        $data = [
            'nama'  => $this->nama,
            'email' => $this->email,
            'role'  => $this->role,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        session()->flash('message', 'User berhasil diperbarui!');
        $this->resetFields();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User berhasil dihapus!');
    }
}