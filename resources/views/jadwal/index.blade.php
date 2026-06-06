@extends('layouts.app')

@section('title', 'Manajemen Kegiatan')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold">Tambah Kegiatan Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('kegiatan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" class="form-control" placeholder="Contoh: Pengajian Malam" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Jam Mulai</label>
                            <input type="time" name="jam_mulai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Jam Selesai</label>
                            <input type="time" name="jam_selesai" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Kegiatan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase small fw-bold">Kegiatan</th>
                                <th class="py-3 text-uppercase small fw-bold text-center">Waktu</th>
                                <th class="pe-4 py-3 text-uppercase small fw-bold text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwals as $j)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $j->nama_kegiatan }}</td>
                                <td class="text-center">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                <td class="pe-4 text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary border-0" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal{{ $j->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <form action="{{ route('kegiatan.destroy', $j->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="modal fade" id="editModal{{ $j->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow rounded-4">
                                                <div class="modal-header border-0">
                                                    <h6 class="modal-title fw-bold text-start">Edit Kegiatan</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('kegiatan.update', $j->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Nama Kegiatan</label>
                                                            <input type="text" name="nama_kegiatan" class="form-control" value="{{ $j->nama_kegiatan }}" required>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label small fw-bold">Jam Mulai</label>
                                                                <input type="time" name="jam_mulai" class="form-control" value="{{ $j->jam_mulai }}" required>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label small fw-bold">Jam Selesai</label>
                                                                <input type="time" name="jam_selesai" class="form-control" value="{{ $j->jam_selesai }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>
                                    Belum ada data kegiatan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(function() {
                // Menghilangkan class 'show' agar terjadi efek fade out Bootstrap
                alert.classList.remove('show');
                
                // Menghapus elemen dari DOM setelah animasi selesai
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 3000); // Waktu tampil 3 detik
        }
    });
</script>
@endsection