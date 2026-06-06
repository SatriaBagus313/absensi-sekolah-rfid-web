<div class="container mt-4" style="max-width: 600px;">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4"><i class="bi bi-person-gear"></i> Pengaturan Profil Saya</h5>

            @if (session()->has('message'))
                <div class="alert alert-success small">{{ session('message') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger small">{{ session('error') }}</div>
            @endif

            <form wire:submit.prevent="updateProfile">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Pengguna</label>
                    <input type="text" class="form-control" wire:model="name">
                    @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Alamat Email</label>
                    <input type="email" class="form-control" wire:model="email">
                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                
                <hr class="my-4 text-muted">
                <h6 class="fw-bold text-secondary mb-3">Ubah Password (Opsional)</h6>

                <div class="mb-3">
                    <label class="form-label small">Password Saat Ini</label>
                    <input type="password" class="form-control" wire:model="current_password">
                    @error('current_password') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label small">Password Baru</label>
                    <input type="password" class="form-control" wire:model="new_password">
                    @error('new_password') <span class="text-danger small">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary px-4 rounded-3 mt-2">Update Profil</button>
            </form>
        </div>
    </div>
</div>