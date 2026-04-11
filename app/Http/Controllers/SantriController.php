<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index()
    {
        // Menampilkan data terbaru dengan paginasi 20 data per halaman
        $santri = Santri::latest()->paginate(20);
        return view('santri.index', compact('santri'));
    }

    public function create()
    {
        return view('santri.create');
    }

    public function store(Request $request)
{
    // 1. Simpan ke tabel santris
    $santri = Santri::create([
        'nama'  => $request->nama,
        'kelas' => $request->kelas,
        'nis'   => $request->nis,
    ]);

    // 2. Simpan UID ke tabel rfid_cards (Hubungkan via santri_id)
    \App\Models\RfidCard::create([
        'santri_id' => $santri->id, // ID santri yang baru saja dibuat
        'uid'       => $request->uid,
    ]);

    return redirect('/santri')->with('success', 'Data Berhasil Disimpan!');
}

    public function edit($id)
    {
        $santri = Santri::findOrFail($id);
        // Pastikan file resources/views/santri/edit.blade.php sudah kamu buat
        return view('santri.edit', compact('santri'));
    }

    public function update(Request $request, $id)
    {
        $santri = Santri::findOrFail($id);

        // Validasi update: UID unik kecuali untuk santri yang sedang diedit ini sendiri
        $request->validate([
            'nama'  => 'required|string|max:255',
            'uid'   => 'nullable|unique:santris,uid,' . $id,
            'kelas' => 'required'
        ]);

        $santri->update([
            'nama'  => $request->nama,
            'uid'   => $request->uid,
            'kelas' => $request->kelas,
        ]);

        return redirect('/santri')->with('success', 'Data santri berhasil diperbarui');
    }

    public function destroy($id)
    {
        Santri::destroy($id);
        return back()->with('success', 'Santri berhasil dihapus');
    }
}