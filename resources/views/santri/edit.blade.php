@extends('layouts.app')

@section('title', 'Edit Santri')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Edit Data Santri</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('santri.update', $santri->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Santri</label>
                <input type="text" name="nama" class="form-control" value="{{ $santri->nama }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">UID Kartu (RFID)</label>
                <input type="text" name="uid" class="form-control" value="{{ $santri->uid }}" placeholder="Tempelkan kartu atau ketik manual">
                <small class="text-muted">Kosongkan jika belum ada kartu.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-control" required>
                    <option value="Reguler" {{ $santri->kelas == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                    <option value="Tahfidz" {{ $santri->kelas == 'Tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('santri.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection