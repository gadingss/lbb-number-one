@extends('layouts.app')

@section('title', 'Catat Absensi')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Catat Absensi Pertemuan</h2>
    <a href="{{ route('admin.absensi.index') }}" class="text-blue-600 hover:underline">
        &larr; Kembali ke Data Absensi
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.absensi.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jadwal</label>
                <select name="jadwal_id" id="jadwal_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Jadwal</option>
                    @foreach($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}">
                            [{{ $jadwal->mataPelajaran->nama_mapel }}] Siswa: {{ $jadwal->siswa->user->name ?? 'N/A' }} | Tutor: {{ $jadwal->tutor->user->name ?? 'N/A' }} ({{ $jadwal->hari }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tutor</label>
                <select name="tutor_id" id="tutor_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Tutor</option>
                    @foreach($tutors as $tutor)
                        <option value="{{ $tutor->id }}">{{ $tutor->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                <select name="siswa_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Siswa</option>
                    @php
                        $siswas = \App\Models\Siswa::with('user')->get();
                    @endphp
                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->id }}">{{ $siswa->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Kehadiran</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="alpha">Alpha</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Absen</label>
                <input type="time" name="jam_absen" value="{{ date('H:i') }}" class="w-full border rounded px-3 py-2">
            </div>



            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Hasil Pertemuan</label>
                <textarea name="hasil_pertemuan" rows="3" class="w-full border rounded px-3 py-2" placeholder="Catatan hasil pembelajaran..."></textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('admin.absensi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
