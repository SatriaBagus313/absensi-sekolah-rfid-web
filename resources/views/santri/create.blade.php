@extends('layouts.app')

@section('title', 'Tambah Santri')

@section('content')

<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Form Registrasi Santri Baru</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/santri">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-select @error('kelas') is-invalid @enderror" required>
                    <option value="">-- Pilih Kelas --</option>
                    <option value="Reguler" {{ old('kelas') == 'Reguler' ? 'selected' : '' }}>Reguler</option>
                    <option value="Tahfidz" {{ old('kelas') == 'Tahfidz' ? 'selected' : '' }}>Tahfidz</option>
                </select>
                @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">UID Kartu RFID</label>
                <div class="input-group">
                    <input type="text" id="uid" name="uid" class="form-control @error('uid') is-invalid @enderror" 
                           value="{{ old('uid') }}" readonly placeholder="Klik scan lalu tempel kartu...">
                    <button type="button" id="scanBtn" class="btn btn-primary">
                        <i class="fas fa-rss"></i> <span id="btnText">Scan Kartu</span>
                    </button>
                </div>
                @error('uid') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                <small class="text-muted" id="statusText">Sensor standby.</small>
            </div>

            <hr>
            <div class="d-flex justify-content-between">
                <a href="/santri" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success">Simpan Data Santri</button>
            </div>
        </form>
    </div>
</div>

<script>
    // ... Kode JavaScript kamu sudah benar, tetap gunakan yang sudah ada ...
    let scanning = false;
    let scanInterval;
    const btn = document.getElementById('scanBtn');
    const btnText = document.getElementById('btnText');
    const statusText = document.getElementById('statusText');
    const uidInput = document.getElementById('uid');

    btn.onclick = function() {
        if (scanning) { stopScanning(); return; }
        startScanning();
    };

    function startScanning() {
        scanning = true;
        btn.classList.replace('btn-primary', 'btn-danger');
        btnText.innerText = "Batal Scan";
        statusText.innerText = "Mencari kartu... Silakan tempelkan kartu RFID.";
        uidInput.value = ""; 
        scanInterval = setInterval(checkUID, 1000);
    }

    function stopScanning() {
        clearInterval(scanInterval);
        scanning = false;
        btn.classList.replace('btn-danger', 'btn-primary');
        btnText.innerText = "Scan Kartu";
    }

    function checkUID() {
        if (!scanning) return;
        fetch('/api/scan-rfid')
            .then(res => res.json())
            .then(data => {
                if (data.uid) {
                    uidInput.value = data.uid;
                    stopScanning();
                    statusText.innerText = "Kartu berhasil terbaca!";
                }
            })
            .catch(err => console.error("Error fetching UID:", err));
    }
</script>
@endsection