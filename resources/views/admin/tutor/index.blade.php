@extends('layouts.app')

@section('title', 'Daftar Tutor')

@section('content')
@if(session('wa_link'))
    <script>
        window.open("{!! session('wa_link') !!}", "_blank");
    </script>
@endif
<!-- Header Section with Asymmetry -->
<div class="flex justify-between items-end mb-10">
    <div>
        <h2 class="text-4xl font-extrabold tracking-tight text-on-background mb-2">Daftar Tutor</h2>
        <p class="text-slate-500 font-medium max-w-md">Kelola dan pantau seluruh pendidik unggulan fakultas LBB Anda.</p>
    </div>
    <a href="{{ route('admin.tutor.create') }}" class="flex items-center gap-2 px-6 py-3 bg-gradient-to-br from-primary to-primary-container text-white rounded-xl font-bold shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
        <span class="material-symbols-outlined" data-icon="person_add">person_add</span>
        + Tambah Tutor
    </a>
</div>

<!-- Top Row: Premium Stats (Bento Style) -->
<div class="grid grid-cols-12 gap-6 mb-8">
    <!-- Spotlight of the Month -->
    <div class="col-span-8 bg-surface-container-lowest rounded-3xl p-8 relative overflow-hidden group">
        <div class="relative z-10 flex h-full">
            <div class="flex-1 pr-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-tertiary-container/10 text-tertiary font-bold text-[10px] tracking-widest uppercase rounded-full mb-4">
                    <span class="material-symbols-outlined text-xs" data-icon="star" data-weight="fill" style="font-variation-settings: 'FILL' 1;">star</span>
                    Sorotan Bulan Ini
                </div>
                
                @if($spotlightTutor)
                    <h3 class="text-3xl font-extrabold text-on-background mb-3">{{ $spotlightTutor->user->name }}</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">Tutor paling aktif dengan rekor {{ $spotlightTutor->jadwals_count }} kelas yang dijadwalkan.</p>
                    
                    <div class="flex gap-8">
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-slate-400 font-bold mb-1">Total Jam Mengajar</p>
                            <p class="text-2xl font-bold text-primary">{{ $totalHours }}h</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase tracking-wider text-slate-400 font-bold mb-1">Total Siswa Diajar</p>
                            <p class="text-2xl font-bold text-primary">{{ $totalStudents }}</p>
                        </div>
                    </div>
                @else
                    <h3 class="text-3xl font-extrabold text-on-background mb-3">Belum Ada Sorotan</h3>
                    <p class="text-slate-600 mb-6 leading-relaxed">Belum ada tutor yang memiliki jadwal pendaftaran mengajar bulan ini.</p>
                @endif
            </div>
            
            <div class="w-48 h-full relative flex items-center justify-center">
                @if($spotlightTutor)
                <div class="w-full h-48 rounded-2xl bg-primary text-white flex items-center justify-center font-black text-6xl shadow-2xl shadow-on-surface/10">
                    {{ substr($spotlightTutor->user->name, 0, 1) }}
                </div>
                <div class="absolute bottom-2 -right-2 bg-white p-2 rounded-xl shadow-lg">
                    <span class="material-symbols-outlined text-primary text-3xl" data-icon="verified" data-weight="fill" style="font-variation-settings: 'FILL' 1;">verified</span>
                </div>
                @endif
            </div>
        </div>
        <!-- Subtle Background Texture -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-20 -mt-20 blur-3xl"></div>
    </div>

    <!-- Subject Growth -->
    <div class="col-span-4 bg-primary text-white rounded-3xl p-8 flex flex-col justify-between relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-primary-fixed/60 font-bold text-[10px] tracking-widest uppercase mb-1">Pertumbuhan Mapel Teratas</p>
            <h3 class="text-2xl font-bold mb-6">{{ $topSubject }}</h3>
            
            <div class="flex items-end gap-3 mb-4">
                <div class="h-12 w-3 bg-primary-fixed/20 rounded-full"></div>
                <div class="h-20 w-3 bg-primary-fixed/40 rounded-full"></div>
                <div class="h-16 w-3 bg-primary-fixed/60 rounded-full"></div>
                <div class="h-28 w-3 bg-primary-fixed/80 rounded-full"></div>
                <div class="h-32 w-3 bg-white rounded-full"></div>
            </div>
            <p class="text-sm font-medium opacity-90">Permintaan untuk mata pelajaran ini meningkat secara signifikan semester ini.</p>
        </div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 border-[20px] border-white/5 rounded-full"></div>
    </div>
</div>

<!-- Tutor Data Table (Organized Ledger) -->
<div class="bg-surface-container-low rounded-3xl overflow-hidden shadow-sm">
    <div class="p-8 pb-4 flex justify-between items-center">
        <h4 class="text-lg font-bold text-on-background">Susunan Pengajar</h4>
        <div class="flex gap-2">
            <button class="p-2 bg-surface-container-lowest text-slate-600 rounded-xl hover:bg-white transition-colors">
                <span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
            </button>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-high/50">
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">No</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Nama Profil</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Keahlian (Subject)</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-center">Status</th>
                    <th class="px-8 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                @forelse ($tutors as $tutor)
                <tr class="group hover:bg-surface-container-high/30 transition-colors border-b border-outline-variant/10 last:border-0">
                    <td class="px-8 py-5 text-sm font-bold text-slate-400">
                        {{ str_pad($loop->iteration + ($tutors->currentPage() - 1) * $tutors->perPage(), 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-primary-fixed text-on-primary-fixed flex items-center justify-center font-bold">
                                {{ substr($tutor->user->name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-on-background">{{ $tutor->user->name ?? '-' }}</p>
                                <p class="text-[11px] text-slate-500">Pendidikan: {{ $tutor->pendidikan_terakhir }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed text-[11px] font-bold rounded-full block w-max mb-1">
                            {{ $tutor->keahlian }}
                        </span>
                        @php
                            $activeCount = $tutor->active_students_count;
                            $kuota = $tutor->kuota_siswa;
                            $isFull = $activeCount >= $kuota;
                        @endphp
                        <span class="text-[11px] font-bold {{ $isFull ? 'text-error' : 'text-slate-500' }}">
                            Kuota: {{ $activeCount }} / {{ $kuota }} Siswa
                        </span>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @if($tutor->user && $tutor->user->is_verified)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-full">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Verified
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 text-amber-700 text-[11px] font-bold rounded-full">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                Pending
                            </span>
                        @endif
                    </td>
                    <td class="px-8 py-5 text-right">
                        <div class="flex justify-end gap-2 transition-opacity">
                            @if($tutor->user && !$tutor->user->is_verified)
                                <button type="button" onclick="openVerifyModal('tutor', '{{ $tutor->id }}', '{{ addslashes($tutor->user->name) }}')" class="p-2 text-emerald-600 hover:bg-emerald-100 rounded-lg transition-colors inline-block" title="Verifikasi">
                                    <span class="material-symbols-outlined text-lg" data-icon="verified">verified</span>
                                </button>
                            @endif
                            <a href="{{ route('admin.tutor.edit', $tutor->id) }}" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors inline-block" title="Edit">
                                <span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
                            </a>
                            <form action="{{ route('admin.tutor.destroy', $tutor->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tutor ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-error hover:bg-error/10 rounded-lg transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 px-6 text-center text-slate-500 text-sm">
                        Belum ada data tutor yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <div class="p-6 bg-surface-container-highest/20 border-t border-slate-200/50">
        {{ $tutors->links() }}
    </div>
</div>
</div>

{{-- Verify Modal --}}
<div id="verifyModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
    <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-xl w-full max-w-md animate-slide-in">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">Verifikasi Tutor</h3>
            <button onclick="closeVerifyModal()" class="text-outline hover:text-on-surface"><span class="material-symbols-outlined">close</span></button>
        </div>
        <p class="text-sm text-on-surface-variant mb-4">Masukkan kode login yang akan dikirimkan kepada <strong id="verifyUserName"></strong> melalui WhatsApp.</p>
        <form id="verifyForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label for="verifyKode" class="block text-sm font-medium text-on-surface mb-1">Kode Login</label>
                <input type="text" id="verifyKode" name="kode" required class="w-full px-4 py-2 bg-surface-container-highest border-none rounded-xl focus:ring-2 focus:ring-primary" placeholder="Masukkan kode login...">
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeVerifyModal()" class="px-4 py-2 rounded-xl text-on-surface-variant hover:bg-surface-variant font-medium">Batal</button>
                <button type="submit" class="px-6 py-2 bg-primary text-white font-bold rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">verified</span>
                    Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Modal Verify Handlers
    function openVerifyModal(type, id, name) {
        document.getElementById('verifyUserName').innerText = name;
        document.getElementById('verifyKode').value = '';
        const form = document.getElementById('verifyForm');
        form.action = `/admin/${type}/${id}/verify`;
        document.getElementById('verifyModal').classList.remove('hidden');
    }

    function closeVerifyModal() {
        document.getElementById('verifyModal').classList.add('hidden');
    }
</script>
<style>
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(100%); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-slide-in {
        animation: slideIn 0.4s ease-out forwards;
    }
</style>
@endsection