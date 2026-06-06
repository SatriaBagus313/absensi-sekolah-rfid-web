@extends('layouts.app')

@section('title', 'Data Santri')

@section('content')
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom p-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Data Santri</h5>
                <p class="text-muted small mb-0">Halaman pengelolaan data sistem</p>
            </div>
            <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addSantriModal">
                <i class="bi bi-plus-circle me-2"></i> Tambah Santri
            </button>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold">Nama</th>
                            <th class="py-3 text-uppercase small fw-bold">UID RFID</th>
                            <th class="py-3 text-uppercase small fw-bold">Kelas</th>
                            <th class="pe-4 py-3 text-uppercase small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($santri as $s)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $s->nama }}</td>
                            <td><code class="bg-light px-2 py-1 rounded">{{ $s->uid }}</code></td>
                            <td><span class="badge bg-info-subtle text-info rounded-pill px-3">{{ $s->kelas }}</span></td>
                            <td class="pe-4 text-center">
                                <a href="{{ route('santri.edit', $s->id) }}" class="btn btn-sm btn-warning rounded-3 text-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('santri.destroy', $s->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-3" onclick="return confirm('Hapus santri ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tambah Santri Modal -->
    <div class="modal fade" id="addSantriModal" tabindex="-1" aria-labelledby="addSantriModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-sm">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="addSantriModalLabel">Tambah Santri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body pt-0">
                    <form method="POST" action="{{ route('santri.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                                <option value="">-- Pilih Kelas --</option>
                                <option value="Reguler" {{ old('kelas') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                <option value="Tahfidz" {{ old('kelas') == 'Tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                            </select>
                            @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">UID Kartu RFID</label>
                            <input type="text" id="uid" name="uid" class="form-control @error('uid') is-invalid @enderror" value="{{ old('uid') }}" readonly placeholder="Klik scan lalu tempel kartu...">
                            @error('uid') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Sensor standby.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Data Santri</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var addModal = new bootstrap.Modal(document.getElementById('addSantriModal'));
                addModal.show();
            });
        </script>
    @endif
@endsection