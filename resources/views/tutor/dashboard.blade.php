@extends('layouts.tutor')

@section('title', 'Dashboard Tutor')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-800">
        Dashboard Tutor
    </h2>
    <p class="text-gray-500 text-sm mt-1">
        Selamat datang, 
        <span class="font-semibold text-indigo-600">
            {{ auth()->user()->name }}
        </span>
    </p>
</div>

{{-- ===================== STATISTIK ===================== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

    <div class="bg-blue-600 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg">Total Pertemuan</h3>
        <p class="text-3xl font-bold mt-2">{{ $totalPertemuan ?? 0 }}</p>
    </div>

    <div class="bg-green-600 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg">Bulan Ini</h3>
        <p class="text-3xl font-bold mt-2">{{ $pertemuanBulanIni ?? 0 }}</p>
    </div>

    <div class="bg-purple-600 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg">Jadwal Minggu Ini</h3>
        <p class="text-3xl font-bold mt-2">{{ $semuaJadwal->count() ?? 0 }}</p>
    </div>

    <div class="bg-orange-500 text-white p-6 rounded-xl shadow">
        <h3 class="text-lg">Mata Pelajaran</h3>
        <p class="text-3xl font-bold mt-2">{{ $semuaJadwal->pluck('mataPelajaran.nama_mapel')->unique()->count() ?? 0 }}</p>
    </div>

</div>

{{-- ===================== JADWAL HARI INI ===================== --}}
<h2 class="text-xl font-semibold mb-4 text-gray-700">
    Jadwal Hari Ini
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

    @forelse($jadwalHariIni as $jadwal)
    <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-600">
        <h3 class="font-bold text-lg text-gray-800">{{ $jadwal->mataPelajaran->nama_mapel }}</h3>
        <p class="text-gray-600 mt-1">
            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
        </p>
        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mt-2">
            {{ $jadwal->hari }}
        </span>
    </div>
    @empty
    <div class="col-span-full bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <p class="text-yellow-800">Tidak ada jadwal hari ini</p>
    </div>
    @endforelse

</div>

{{-- ===================== SEMUA JADWAL ===================== --}}
<h2 class="text-xl font-semibold mb-4 text-gray-700">
    Semua Jadwal Mengajar
</h2>

<div class="bg-white rounded-lg shadow overflow-hidden mb-10">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hari</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($semuaJadwal as $jadwal)
            <tr>
                <td class="px-6 py-4">{{ $jadwal->hari }}</td>
                <td class="px-6 py-4">{{ $jadwal->mataPelajaran->nama_mapel }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada jadwal</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ===================== RIWAYAT ABSENSI TERBARU ===================== --}}
<h2 class="text-xl font-semibold mb-4 text-gray-700">
    Riwayat Pertemuan Terbaru
</h2>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($riwayatAbsensi as $absensi)
            <tr>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}</td>
                <td class="px-6 py-4">{{ $absensi->siswa->user->name }}</td>
                <td class="px-6 py-4">{{ $absensi->jadwal->mataPelajaran->nama_mapel }}</td>
                <td class="px-6 py-4">
                    @if($absensi->status == 'hadir')
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Hadir</span>
                    @else
                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">{{ $absensi->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
