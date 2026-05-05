@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Tambah Jadwal Tutor</h2>
    <a href="{{ route('admin.jadwal.index') }}" class="text-blue-600 hover:underline">
        &larr; Kembali ke Data Jadwal
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.jadwal.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tutor</label>
                <select name="tutor_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Tutor</option>
                    @foreach($tutors as $tutor)
                        @php
                            $activeCount = $tutor->active_students_count;
                            $kuota = $tutor->kuota_siswa;
                            $isFull = $activeCount >= $kuota;
                        @endphp
                        <option value="{{ $tutor->id }}" {{ $isFull ? 'disabled' : '' }}>
                            {{ $tutor->user->name }} 
                            @if($isFull)
                                (Kuota Penuh: {{ $activeCount }}/{{ $kuota }})
                            @else
                                (Sisa Kuota: {{ $kuota - $activeCount }})
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                <select name="siswa_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Siswa</option>
                    @foreach($siswas as $siswa)
                        <option value="{{ $siswa->id }}">{{ $siswa->user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                <select name="mata_pelajaran_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mapels as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                <select name="hari" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Hari</option>
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Simpan
            </button>
            <a href="{{ route('admin.jadwal.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
