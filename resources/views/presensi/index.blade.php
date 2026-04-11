@extends('layouts.app')

@section('content')
@section('title', 'Log Presensi')


    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="p-4 bg-light border-bottom">
                <form action="/presensi" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') ?? date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary px-4">Filter</button>
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
                        @forelse($presensi as $data)
                        <tr>
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