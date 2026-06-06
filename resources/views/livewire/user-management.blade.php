<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">{{ $isEditMode ? 'Edit User' : 'Tambah User Baru' }}</h5>
                    
                    @if (session()->has('message'))
                        <div class="alert alert-success small rounded-3">{{ session('message') }}</div>
                    @endif

                    <form wire:submit.prevent="{{ $isEditMode ? 'update' : 'store' }}">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" wire:model="nama">
                            @error('nama') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" class="form-control" wire:model="email">
                            @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Role Akses</label>
                            <select class="form-select" wire:model="role">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                            @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password {{ $isEditMode ? '(Kosongkan jika tak diubah)' : '' }}</label>
                            <input type="password" class="form-control" wire:model="password">
                            @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 rounded-3">
                                {{ $isEditMode ? 'Update' : 'Simpan' }}
                            </button>
                            @if($isEditMode)
                                <button type="button" wire:click="resetFields" class="btn btn-light w-100 rounded-3">Batal</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Daftar Pengguna Sistem</h5>
                    
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->nama }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge {{ $user->role === 'superadmin' ? 'bg-danger' : 'bg-primary' }}">
                                            {{ strtoupper($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                            {{ $user->status ?? 'aktif' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button wire:click="edit({{ $user->id }})" class="btn btn-sm btn-outline-warning rounded-2 me-1">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button onclick="confirm('Hapus user ini?') || event.stopImmediatePropagation()" wire:click="delete({{ $user->id }})" class="btn btn-sm btn-outline-danger rounded-2">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> </div> ```
