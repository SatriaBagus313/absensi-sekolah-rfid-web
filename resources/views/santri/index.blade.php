@extends('layouts.app') {{-- Pastikan menggunakan layout yang sama --}}

@section('content')
@section('title', 'Data Santri')

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom p-4">
            <a href="{{ route('santri.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-circle me-2"></i> Tambah Santri
            </a>
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
</div>
@endsection