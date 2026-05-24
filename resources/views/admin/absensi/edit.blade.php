@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Edit Absensi</h2>
    <a href="{{ route('admin.absensi.index') }}" class="text-blue-600 hover:underline">
        &larr; Kembali ke Data Absensi
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.absensi.update', $absensi->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal</label>
                <select name="jadwal_id" class="w-full border rounded px-3 py-2" required>
                    @foreach($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}" {{ $absensi->jadwal_id == $jadwal->id ? 'selected' : '' }}>
                            [{{ $jadwal->mataPelajaran->nama_mapel }}] Siswa: {{ $jadwal->siswa->user->name ?? 'N/A' }} | Tutor: {{ $jadwal->tutor->user->name ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $absensi->tanggal }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="hadir" {{ $absensi->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ $absensi->status == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="alpha" {{ $absensi->status == 'alpha' ? 'selected' : '' }}>Alpha</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Absen</label>
                <input type="time" name="jam_absen" value="{{ $absensi->jam_absen }}" class="w-full border rounded px-3 py-2">
            </div>



            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Pertemuan</label>
                <textarea name="hasil_pertemuan" rows="3" class="w-full border rounded px-3 py-2">{{ $absensi->hasil_pertemuan }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Update
            </button>
            <a href="{{ route('admin.absensi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
