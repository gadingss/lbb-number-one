@extends('layouts.tutor')

@section('title', 'Catat Pertemuan')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Catat Pertemuan Baru</h2>
    <a href="{{ route('tutor.absensi.index') }}" class="text-blue-600 hover:underline">
        &larr; Kembali ke Riwayat
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('tutor.absensi.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal</label>
                <select name="jadwal_id" id="jadwal_id" class="w-full border rounded px-3 py-2" required onchange="updateTanggal()">
                    <option value="">Pilih Jadwal</option>
                    
                    <optgroup label="Jadwal Pengganti (Reschedule)">
                        @foreach($jadwalPenggantis as $jp)
                            <option value="pengganti_{{ $jp->id }}" data-tanggal="{{ $jp->tanggal_pengganti }}" {{ $selectedJadwal == 'pengganti_'.$jp->id ? 'selected' : '' }}>
                                {{ $jp->jadwal->mataPelajaran->nama_mapel }} - Pengganti ({{ \Carbon\Carbon::parse($jp->tanggal_pengganti)->format('d M') }})
                            </option>
                        @endforeach
                    </optgroup>
                    
                    <optgroup label="Jadwal Rutin">
                        @foreach($jadwals as $jadwal)
                            <option value="rutin_{{ $jadwal->id }}" data-tanggal="{{ date('Y-m-d') }}" {{ $selectedJadwal == 'rutin_'.$jadwal->id ? 'selected' : '' }}>
                                {{ $jadwal->mataPelajaran->nama_mapel }} ({{ $jadwal->hari }})
                            </option>
                        @endforeach
                    </optgroup>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Kehadiran</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="hadir">Hadir</option>
                    <option value="tidak_hadir">Tidak Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <textarea name="catatan" rows="2" class="w-full border rounded px-3 py-2" placeholder="Opsional..."></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Pertemuan</label>
                <textarea name="hasil_pertemuan" rows="3" class="w-full border rounded px-3 py-2" placeholder="Catatan hasil pembelajaran hari ini..."></textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('tutor.absensi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    function updateTanggal() {
        const select = document.getElementById('jadwal_id');
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption && selectedOption.dataset.tanggal) {
            document.getElementById('tanggal').value = selectedOption.dataset.tanggal;
        }
    }
    
    // Call on load in case a query parameter selected an option
    document.addEventListener('DOMContentLoaded', updateTanggal);
</script>
@endsection
