@extends('layouts.app')

@section('title', 'Log Presensi')

@section('content')
<div class="container-fluid"> 
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="p-4 bg-light border-bottom">
                <form action="/presensi" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted mb-1">Pilih Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') ?? date('Y-m-d') }}">
                    </div>
                    
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                        
                        <a href="{{ route('presensi.export', ['tanggal' => request('tanggal')]) }}" class="btn btn-success px-4 ms-2">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </a>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold">Nama Santri</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Kegiatan</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Status</th>
                            <th class="pe-4 py-3 text-uppercase small fw-bold text-end">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $data)
                        <tr>
                            <td class="ps-4">{{ $data->santri->nama ?? '-' }}</td>
                            <td class="text-center">{{ $data->jadwal->nama_kegiatan ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge {{ $data->status == 'hadir' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">{{ $data->jam_masuk }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-info-circle fs-4 d-block mb-2"></i>
                                Tidak ada data presensi pada tanggal ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection