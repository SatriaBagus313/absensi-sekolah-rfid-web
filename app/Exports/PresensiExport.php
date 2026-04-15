<?php

namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PresensiExport implements FromQuery, WithMapping, WithHeadings
{
    protected $tanggal;

    public function __construct($tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function query()
    {
        // Mengambil data berdasarkan tanggal yang dipilih di filter
        return Presensi::with(['santri', 'jadwal'])
            ->whereDate('tanggal', $this->tanggal);
    }

    // Mengatur kolom apa saja yang muncul di Excel
    public function map($presensi): array
    {
        return [
            $presensi->santri->nama,
            $presensi->jadwal->nama_kegiatan,
            $presensi->status,
            $presensi->jam_masuk,
            $presensi->tanggal,
        ];
    }

    // Membuat judul header di baris pertama Excel
    public function headings(): array
    {
        return [
            'Nama Santri',
            'Kegiatan',
            'Status',
            'Jam Masuk',
            'Tanggal',
        ];
    }
}