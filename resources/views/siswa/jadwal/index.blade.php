@extends('layouts.siswa')

@section('title', 'Jadwal Les')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Jadwal Les & Izin</h2>
    <p class="text-gray-500">Kelola jadwal les rutin dan pengajuan izin/reschedule</p>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
        {{ session('error') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- BAGIAN KIRI: JADWAL RUTIN --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Jadwal Rutin</h3>
            
            @php
                $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                $jadwalsByHari = $jadwals->groupBy('hari');
            @endphp

            @foreach($hariList as $hari)
                @if(isset($jadwalsByHari[$hari]) && $jadwalsByHari[$hari]->count() > 0)
                <div class="mb-6 last:mb-0">
                    <h4 class="font-semibold text-gray-700 mb-3 bg-gray-50 px-3 py-1 rounded">{{ $hari }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($jadwalsByHari[$hari] as $jadwal)
                        @php
                            $hariInggris = [
                                'Senin' => 'Monday', 'Selasa' => 'Tuesday', 'Rabu' => 'Wednesday',
                                'Kamis' => 'Thursday', 'Jumat' => 'Friday', 'Sabtu' => 'Saturday', 'Minggu' => 'Sunday'
                            ];
                            $namaHari = $hariInggris[$jadwal->hari] ?? 'Monday';
                            
                            $upcomingDate = \Carbon\Carbon::parse('next ' . $namaHari);
                            if (now()->format('l') == $namaHari && now()->format('H:i') <= \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) {
                                $upcomingDate = now();
                            }
                        @endphp
                        <div class="border rounded-lg p-4 relative border-l-4 border-l-blue-500">
                            <h5 class="font-bold text-gray-800">{{ $jadwal->mataPelajaran->nama_mapel }}</h5>
                            <p class="text-gray-600 text-sm mt-1">
                                <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                            </p>
                            <p class="text-blue-600 text-xs mt-1 font-semibold">
                                <i class="far fa-calendar-check mr-1"></i> Sesi Terdekat: {{ $upcomingDate->isoFormat('D MMMM Y') }}
                            </p>
                            <p class="text-gray-500 text-sm mt-1">
                                <i class="far fa-user mr-1"></i> Tutor: {{ $jadwal->tutor->user->name }}
                            </p>
                            
                            <div class="mt-3 pt-3 border-t">
                                <button onclick="openIzinModal({{ $jadwal->id }}, '{{ $jadwal->mataPelajaran->nama_mapel }}', '{{ $upcomingDate->format('Y-m-d') }}')" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                    Ajukan Izin / Reschedule
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            @endforeach

            @if($jadwals->isEmpty())
                <p class="text-gray-500 text-center py-4">Belum ada jadwal rutin tersedia.</p>
            @endif
        </div>
        
        {{-- JADWAL PENGGANTI (RESCHEDULE) --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Jadwal Pengganti (Reschedule)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($jadwalPenggantis as $jp)
                    <div class="border rounded-lg p-4 bg-blue-50 border-blue-200">
                        <div class="flex justify-between items-start">
                            <h5 class="font-bold text-gray-800">{{ $jp->jadwal->mataPelajaran->nama_mapel }}</h5>
                            <span class="text-xs font-bold px-2 py-1 bg-blue-100 text-blue-700 rounded uppercase">Pengganti</span>
                        </div>
                        <p class="text-gray-600 text-sm mt-2 font-medium">
                            <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($jp->tanggal_pengganti)->isoFormat('dddd, D MMMM Y') }}
                        </p>
                        <p class="text-gray-600 text-sm mt-1">
                            <i class="far fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($jp->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jp->jam_selesai)->format('H:i') }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-2 text-center py-4">Belum ada jadwal pengganti yang aktif.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- BAGIAN KANAN: STATUS IZIN & MENUNGGU RESPON --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Status Pengajuan Izin</h3>
            
            <div class="space-y-4">
                @forelse($pengajuanIzins as $izin)
                    <div class="border rounded-lg p-4 {{ $izin->status == 'menunggu_konfirmasi_pengaju' && $izin->tipe_pengaju == 'tutor' ? 'border-orange-400 bg-orange-50' : 'bg-gray-50' }}">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold text-gray-500 uppercase">{{ \Carbon\Carbon::parse($izin->created_at)->format('d M Y') }}</span>
                            @if($izin->status == 'menunggu_lawan')
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Menunggu Respon</span>
                            @elseif($izin->status == 'menunggu_konfirmasi_pengaju')
                                <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full">Butuh Konfirmasi</span>
                            @elseif($izin->status == 'reschedule_berhasil')
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Reschedule Selesai</span>
                            @elseif($izin->status == 'ditolak')
                                <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">Ditolak</span>
                            @endif
                        </div>
                        
                        <p class="font-bold text-sm">{{ $izin->jadwal->mataPelajaran->nama_mapel }}</p>
                        <p class="text-xs text-gray-600 mt-1">Tgl Izin: <span class="font-semibold">{{ \Carbon\Carbon::parse($izin->tanggal_izin)->format('d M Y') }}</span></p>
                        <p class="text-xs text-gray-600 mt-1">Diajukan oleh: <span class="font-semibold">{{ $izin->pengaju->name }} ({{ ucfirst($izin->tipe_pengaju) }})</span></p>
                        
                        {{-- JIKA SISWA YG MENGAJUKAN, DAN MENUNGGU KONFIRMASI DARI SISWA SENDIRI (TUTOR SUDAH MENGUSULKAN) --}}
                        @if($izin->tipe_pengaju == 'siswa' && $izin->status == 'menunggu_konfirmasi_pengaju')
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-xs font-bold text-gray-700 mb-2">Tutor mengusulkan jadwal pengganti:</p>
                                <p class="text-xs text-blue-700 font-medium bg-blue-50 p-2 rounded">
                                    {{ $izin->usulan_hari }}, {{ \Carbon\Carbon::parse($izin->usulan_tanggal)->format('d M Y') }}<br>
                                    Jam: {{ \Carbon\Carbon::parse($izin->usulan_jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($izin->usulan_jam_selesai)->format('H:i') }}
                                </p>
                                <form action="{{ route('siswa.izin.accept', $izin->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="w-full bg-blue-600 text-white text-xs font-bold py-2 rounded hover:bg-blue-700 transition-colors">
                                        Setujui Reschedule
                                    </button>
                                </form>
                            </div>
                        @endif

                        {{-- JIKA TUTOR YG MENGAJUKAN, DAN SISWA YG HARUS APPROVE & PROPOSE --}}
                        @if($izin->tipe_pengaju == 'tutor' && $izin->status == 'menunggu_lawan')
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-xs text-gray-600 mb-2">Tutor meminta izin. Anda perlu memberikan persetujuan dan jadwal pengganti.</p>
                                <div class="flex gap-2">
                                    <button onclick="openProposeModal({{ $izin->id }})" class="flex-1 bg-green-600 text-white text-xs font-bold py-2 rounded hover:bg-green-700">Terima & Usulkan</button>
                                    <form action="{{ route('siswa.izin.reject', $izin->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Tolak izin tutor?')">
                                        @csrf
                                        <button type="submit" class="w-full bg-red-100 text-red-700 text-xs font-bold py-2 rounded hover:bg-red-200">Tolak</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center">Belum ada riwayat izin.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- MODAL AJUKAN IZIN --}}
<div id="izinModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Ajukan Izin & Reschedule</h3>
            <button onclick="closeIzinModal()" class="text-gray-500 hover:text-gray-800"><i class="fas fa-times"></i></button>
        </div>
        <form action="{{ route('siswa.izin.store') }}" method="POST">
            @csrf
            <input type="hidden" name="jadwal_id" id="jadwal_id_izin">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                <input type="text" id="mapel_izin_text" class="w-full bg-gray-100 border-none rounded-lg px-3 py-2 text-sm" disabled>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Izin (Tidak Hadir)</label>
                <input type="date" name="tanggal_izin" required min="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 text-sm">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan</label>
                <textarea name="alasan" required rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-3 py-2 text-sm"></textarea>
            </div>
            
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeIzinModal()" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Kirim Pengajuan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL PROPOSE RESCHEDULE (Approve izin tutor) --}}
<div id="proposeModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Terima Izin & Usulkan Pengganti</h3>
            <button onclick="closeProposeModal()" class="text-gray-500 hover:text-gray-800"><i class="fas fa-times"></i></button>
        </div>
        <p class="text-sm text-gray-600 mb-4">Pilih waktu yang cocok untuk mengganti kelas ini. Sistem akan mengecek agar tidak bentrok.</p>
        <form id="proposeForm" method="POST" action="">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengganti</label>
                <input type="date" name="usulan_tanggal" required min="{{ date('Y-m-d') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 px-3 py-2 text-sm">
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                    <input type="time" name="usulan_jam_mulai" required class="w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                    <input type="time" name="usulan_jam_selesai" required class="w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-sm">
                </div>
            </div>
            
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeProposeModal()" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">Usulkan Jadwal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openIzinModal(jadwalId, mapelName, upcomingDate) {
        document.getElementById('jadwal_id_izin').value = jadwalId;
        document.getElementById('mapel_izin_text').value = mapelName;
        // set default date if available
        if (upcomingDate) {
            document.querySelector('input[name="tanggal_izin"]').value = upcomingDate;
        }
        document.getElementById('izinModal').classList.remove('hidden');
    }
    function closeIzinModal() {
        document.getElementById('izinModal').classList.add('hidden');
    }

    function openProposeModal(izinId) {
        document.getElementById('proposeForm').action = '/siswa/izin/' + izinId + '/approve';
        document.getElementById('proposeModal').classList.remove('hidden');
    }
    function closeProposeModal() {
        document.getElementById('proposeModal').classList.add('hidden');
    }
</script>
@endsection
