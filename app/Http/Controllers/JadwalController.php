<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::all();
        return view('jadwal.index', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        Jadwal::create($request->all());

        return redirect()->back()->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus!');
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_kegiatan' => 'required',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required',
    ]);

    $jadwal = Jadwal::findOrFail($id);
    $jadwal->update($request->all());

    return redirect()->back()->with('success', 'Kegiatan berhasil diperbarui!');
}
}