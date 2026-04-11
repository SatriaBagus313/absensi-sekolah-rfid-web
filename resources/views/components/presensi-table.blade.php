<?php

use Livewire\Component;
use App\Models\Presensi;

new class extends Component
{
    // Fungsi ini akan dijalankan otomatis oleh Livewire
    public function render()
    {
        return view('livewire.presensi-table', [
            'latest' => Presensi::with('santri')->latest()->limit(10)->get()
        ]);
    }
}; ?>

<div wire:poll.2s> <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latest as $p)
            <tr>
                <td>{{ $p->santri->nama ?? 'Nama tidak ditemukan' }}</td>
                <td>
                    <span class="badge {{ $p->status == 'hadir' ? 'bg-success' : 'bg-danger' }}">
                        {{ $p->status }}
                    </span>
                </td>
                <td>{{ $p->created_at->format('H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>