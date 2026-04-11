<div wire:poll.2s>
    {{-- STATISTIC CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-primary bg-opacity-10 rounded-3 text-primary me-3">
                            <i class="bi bi-person-check fs-3"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-semibold" style="font-size: 0.7rem;">Total Presensi</p>
                            <h2 class="fw-bold mb-0 text-dark">{{ $totalHariIni }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="p-3 bg-danger bg-opacity-10 rounded-3 text-danger me-3">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1 small text-uppercase fw-semibold" style="font-size: 0.7rem;">Terlambat</p>
                            <h2 class="text-danger fw-bold mb-0">{{ $terlambat }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE SECTION --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-0">
            <div class="d-flex align-items-center">
                <div class="me-3 p-2 bg-light rounded text-muted">
                    <i class="bi bi-journal-text fs-4"></i>
                </div>
                <h5 class="fw-bold mb-0">Absensi Terbaru</h5>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold">NAMA SANTRI</th>
                        <th class="py-3 text-muted small fw-bold">KEGIATAN</th>
                        <th class="py-3 text-muted small fw-bold text-center">STATUS</th>
                        <th class="pe-4 py-3 text-muted small fw-bold text-end">WAKTU TAP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latest as $p)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-semibold text-dark">{{ $p->santri->nama ?? 'Nama tidak ditemukan' }}</span>
                        </td>
                        <td>
                            <span class="text-secondary">{{ $p->jadwal->nama_kegiatan ?? 'Luar Jadwal' }}</span>
                        </td>
                        <td class="text-center">
                            @if(strtolower($p->status) == 'terlambat')
                                <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 border border-danger border-opacity-25">Terlambat</span>
                            @else
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success px-3 border border-success border-opacity-25">Hadir</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end text-muted font-monospace small">
                            {{ $p->created_at->format('H:i:s') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        {{-- Colspan diubah ke 4 sesuai jumlah th --}}
                        <td colspan="4" class="py-5 text-center bg-white border-0">
                            <div class="py-4">
                                <i class="bi bi-info-circle text-muted fs-1 d-block mb-3"></i>
                                <h6 class="fw-bold text-dark">Belum ada aktivitas hari ini</h6>
                                <p class="text-muted small">Data akan muncul secara otomatis saat santri melakukan tapping kartu RFID.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>