<?php

namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class PresensiExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $tanggal;

    // Menerima filter tanggal dari controller jika ada
    public function __construct($tanggal = null)
    {
        $this->tanggal = $tanggal ?? Carbon::now()->toDateString();
    }

    public function collection()
    {
        // Mengambil data presensi berdasarkan tanggal yang dipilih
        return Presensi::with('santri') // Sesuaikan dengan relasi di modelmu
            ->whereDate('created_at', $this->tanggal)
            ->get();
    }

    // 1. FORMAT DATA (Agar rapi sesuai kolom)
    public function map($presensi): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        return [
            $rowNumber,
            $presensi->santri->nama ?? 'Tidak Diketahui',
            $presensi->kegiatan ?? 'Presensi Rutin',
            strtoupper($presensi->status),
            Carbon::parse($presensi->created_at)->format('H:i:s'),
            Carbon::parse($presensi->created_at)->translatedFormat('d F Y'),
        ];
    }

    // 2. HEADER TABEL
    public function headings(): array
    {
        return [
            ['LAPORAN LOG PRESENSI RFID - AL MAGFIROH'], // Judul Atas
            ['Tanggal: ' . Carbon::parse($this->tanggal)->translatedFormat('d F Y')], // Sub-judul
            [], // Baris Kosong
            [   // Header Tabel Sebenarnya
                'NO',
                'NAMA SANTRI',
                'KEGIATAN',
                'STATUS',
                'WAKTU TAP',
                'TANGGAL'
            ]
        ];
    }

    // 3. TEMPLATE DESAIN & STYLING
    public function styles(Worksheet $sheet)
    {
        // Merge cell untuk judul utama & sub-judul
        $sheet->mergeCells('A1:F1');
        $sheet->mergeCells('A2:F2');

        // Style untuk Judul Utama
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Style untuk Sub-judul
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setSize(11);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Style khusus untuk Header Tabel (Baris ke-4)
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // Teks Putih
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0A61e4'], // Warna Biru matching dengan Sidebar web kamu
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A4:F4')->applyFromArray($headerStyle);
        $sheet->getRowDimension(4)->setRowHeight(25); // Membuat header lebih tinggi

        // Mendapatkan total baris data untuk memberikan border dan alignment
        $highestRow = $sheet->getHighestRow();

        // Style untuk isi data (Baris 5 sampai terakhir)
        for ($row = 5; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20); // Tinggi baris data rapi

            // Beri border tipis di setiap sel data
            $sheet->getStyle("A{$row}:F{$row}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            
            // Tengahkan kolom nomor, status, waktu tap, dan tanggal
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("D{$row}:F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        return [];
    }
}