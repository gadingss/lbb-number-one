@extends('layouts.app')

@section('title', 'Manajemen Siswa')

@section('content')
{{-- Success Notification (Toast-style) --}}
@if(session('success'))
    <div id="toast-success" class="fixed top-20 right-8 z-50 flex items-center gap-3 bg-surface-container-lowest text-on-surface px-6 py-4 rounded-2xl shadow-xl border border-outline-variant/10 animate-slide-in">
        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
        <div>
            <p class="font-bold text-sm">Berhasil!</p>
            <p class="text-xs text-on-surface-variant">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('toast-success').remove()" class="ml-4 text-outline hover:text-on-surface transition-colors">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>
    </div>
@endif

@if(session('wa_link'))
    <script>
        window.open("{!! session('wa_link') !!}", "_blank");
    </script>
@endif

{{-- Welcome & Title Section --}}
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <h3 class="font-headline text-3xl font-extrabold text-on-surface tracking-tight">Direktori Siswa</h3>
        <p class="text-on-surface-variant mt-1">Kelola dan pantau data akademis seluruh siswa di LBB Number One.</p>
    </div>
    <a href="{{ route('admin.siswa.create') }}"
       class="flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-bold hover:shadow-xl hover:shadow-primary/20 transition-all duration-300 hover:scale-[1.02] active:scale-95">
        <span class="material-symbols-outlined">person_add</span>
        + Tambah Siswa
    </a>
</div>

{{-- Highlights Section (Bento Style) --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Achievement / Featured Student Card --}}
    <div class="md:col-span-2 bg-surface-container-lowest p-8 rounded-[2rem] flex flex-col md:flex-row items-center gap-8 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-20 -mt-20 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="relative z-10 w-32 h-32 rounded-[2rem] overflow-hidden flex-shrink-0 border-4 border-surface-container-low shadow-xl bg-primary-fixed flex items-center justify-center">
            @if($siswas->count() > 0)
                <span class="text-5xl font-black text-primary">{{ substr($siswas->first()->user->name ?? 'S', 0, 1) }}</span>
            @else
                <span class="material-symbols-outlined text-5xl text-primary">school</span>
            @endif
        </div>
        <div class="relative z-10 flex-1 text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-tertiary-container text-white rounded-full text-xs font-bold mb-4">
                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                Siswa Terdaftar Terbaru
            </div>
            @if($siswas->count() > 0)
                <h4 class="text-2xl font-headline font-bold text-on-surface">{{ $siswas->first()->user->name ?? '-' }}</h4>
                <p class="text-on-surface-variant font-medium">{{ $siswas->first()->kelas ?? '-' }} • {{ $siswas->first()->sekolah ?? '-' }}</p>
            @else
                <h4 class="text-2xl font-headline font-bold text-on-surface">Belum Ada Siswa</h4>
                <p class="text-on-surface-variant font-medium">Tambahkan siswa pertama untuk memulai</p>
            @endif
            <div class="mt-6 flex items-center justify-center md:justify-start gap-4">
                <div class="bg-surface-container-low px-4 py-2 rounded-xl">
                    <span class="block text-xs text-outline font-bold uppercase">Total Siswa</span>
                    <span class="text-xl font-black text-primary">{{ $totalSiswa }}</span>
                </div>
                <div class="bg-primary/10 px-4 py-2 rounded-xl border border-primary/20">
                    <span class="block text-xs text-primary font-bold uppercase">Terdaftar</span>
                    <div class="flex items-center text-primary font-black text-xl">
                        <span class="material-symbols-outlined">groups</span>
                        {{ $totalSiswa }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Summary --}}
    <div class="bg-primary px-8 py-8 rounded-[2rem] text-white flex flex-col justify-between relative overflow-hidden">
        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-t from-black/20 to-transparent"></div>
        <div>
            <span class="material-symbols-outlined text-4xl opacity-50 mb-4">analytics</span>
            <h4 class="text-lg font-bold opacity-80">Total Siswa Aktif</h4>
            <p class="text-5xl font-black mt-2 tracking-tighter">{{ $totalSiswa }}</p>
        </div>
        <div class="relative z-10 mt-8">
            <p class="text-sm font-medium opacity-90 leading-relaxed">Data direktori siswa yang terdaftar di LBB Number One.</p>
            <div class="w-full h-2 bg-white/20 rounded-full mt-3 overflow-hidden">
                <div class="w-3/4 h-full bg-white rounded-full transition-all duration-1000"></div>
            </div>
        </div>
    </div>
</div>

{{-- Table Section (Organized Ledger) --}}
<div class="bg-surface-container-low rounded-[2rem] overflow-hidden">
    <div class="p-8 flex items-center justify-between bg-white/40 backdrop-blur-sm">
        <h4 class="text-xl font-headline font-bold">Daftar Siswa</h4>
        <div class="flex gap-2">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-sm">search</span>
                <input id="searchInput" type="text" placeholder="Cari siswa..."
                       class="pl-10 pr-4 py-2 bg-surface-container-highest border-none rounded-full text-sm focus:ring-2 focus:ring-primary w-48 transition-all"
                       onkeyup="filterTable()">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table id="siswaTable" class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-high/50">
                    <th class="px-8 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-outline">No</th>
                    <th class="px-8 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-outline">Nama Siswa</th>
                    <th class="px-8 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-outline">Kelas</th>
                    <th class="px-8 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-outline">Sekolah</th>
                    <th class="px-8 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-outline">No HP</th>
                    <th class="px-8 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-outline">Status</th>
                    <th class="px-8 py-4 text-[10px] uppercase tracking-[0.15em] font-black text-outline text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-transparent">
                @forelse($siswas as $siswa)
                    <tr class="bg-surface-container-lowest hover:bg-primary-fixed/30 transition-colors group cursor-pointer border-b border-surface-container-high">
                        <td class="px-8 py-5 text-sm font-bold text-outline">
                            {{ str_pad($loop->iteration + (($siswas->currentPage() - 1) * $siswas->perPage()), 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-surface-container-high bg-secondary-container flex items-center justify-center text-on-secondary-container font-black text-lg">
                                    {{ substr($siswa->user->name ?? 'S', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface">{{ $siswa->user->name ?? '-' }}</p>
                                    <p class="text-xs text-outline font-medium">{{ $siswa->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-sm font-semibold">{{ $siswa->kelas ?? '-' }}</td>
                        <td class="px-8 py-5 text-sm">
                            <span class="px-3 py-1 bg-primary-fixed text-on-primary-fixed-variant rounded-full font-bold text-xs uppercase tracking-wider">
                                {{ $siswa->sekolah ?? '-' }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-sm font-medium text-on-surface-variant">{{ $siswa->no_hp ?? '-' }}</td>
                        <td class="px-8 py-5 text-sm">
                            @if($siswa->user && $siswa->user->is_verified)
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full font-bold text-xs uppercase tracking-wider">
                                    Verified
                                </span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full font-bold text-xs uppercase tracking-wider">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                @if($siswa->user && !$siswa->user->is_verified)
                                    <button type="button" onclick="openVerifyModal('siswa', '{{ $siswa->id }}', '{{ addslashes($siswa->user->name) }}')" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-emerald-100 text-outline-variant hover:text-emerald-600 transition-all" title="Verifikasi">
                                        <span class="material-symbols-outlined">verified</span>
                                    </button>
                                @endif
                                @if($siswa->latitude && $siswa->longitude)
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $siswa->latitude }},{{ $siswa->longitude }}"
                                       target="_blank"
                                       class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-blue-100 text-outline-variant hover:text-blue-600 transition-all"
                                       title="Lihat Rute di Maps">
                                        <span class="material-symbols-outlined">directions</span>
                                    </a>
                                @else
                                    <button type="button" onclick="alert('Siswa ini belum mengatur titik lokasi (GPS) di pengaturan profilnya.')"
                                       class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 text-outline-variant opacity-50 transition-all"
                                       title="Lokasi Belum Diatur">
                                        <span class="material-symbols-outlined">location_disabled</span>
                                    </button>
                                @endif
                                <a href="{{ route('admin.siswa.edit', $siswa->id) }}"
                                   class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-surface-variant text-outline-variant hover:text-primary transition-all"
                                   title="Edit Siswa">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa {{ $siswa->user->name ?? '' }}? Tindakan ini tidak dapat dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-error-container text-outline-variant hover:text-error transition-all"
                                            title="Hapus Siswa">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-20 h-20 rounded-[2rem] bg-surface-container-high flex items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl text-outline">group_off</span>
                                </div>
                                <div>
                                    <p class="font-bold text-on-surface text-lg">Belum Ada Data Siswa</p>
                                    <p class="text-on-surface-variant text-sm mt-1">Mulai dengan menambahkan siswa pertama ke dalam sistem.</p>
                                </div>
                                <a href="{{ route('admin.siswa.create') }}"
                                   class="mt-2 flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-bold hover:shadow-xl hover:shadow-primary/20 transition-all">
                                    <span class="material-symbols-outlined">person_add</span>
                                    Tambah Siswa Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination Footer --}}
    @if($siswas->count() > 0)
        <div class="p-6 bg-surface-container-highest/20 border-t border-surface-container-high flex items-center justify-between">
            <p class="text-xs font-bold text-outline">
                Menampilkan {{ $siswas->firstItem() }} - {{ $siswas->lastItem() }} dari {{ $siswas->total() }} siswa
            </p>
            <div class="flex gap-2">
                {{-- Previous Page --}}
                @if($siswas->onFirstPage())
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant text-outline opacity-50 cursor-not-allowed">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $siswas->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant text-outline hover:bg-surface transition-colors">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </a>
                @endif

                {{-- Page Numbers --}}
                @foreach($siswas->getUrlRange(1, $siswas->lastPage()) as $page => $url)
                    @if($page == $siswas->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary text-white font-bold text-xs">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant text-outline font-bold text-xs hover:bg-surface transition-colors">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page --}}
                @if($siswas->hasMorePages())
                    <a href="{{ $siswas->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant text-outline hover:bg-surface transition-colors">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </a>
                @else
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-outline-variant text-outline opacity-50 cursor-not-allowed">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>

</div>

{{-- Verify Modal --}}
<div id="verifyModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/50 backdrop-blur-sm">
    <div class="bg-surface-container-lowest p-8 rounded-2xl shadow-xl w-full max-w-md animate-slide-in">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold">Verifikasi User</h3>
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

{{-- Bottom spacer --}}
<div class="h-10"></div>
@endsection

@section('scripts')
<script>
    // Auto-dismiss toast after 5 seconds
    setTimeout(() => {
        const toast = document.getElementById('toast-success');
        if (toast) {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);

    // Simple table search filter
    function filterTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#siswaTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(input) ? '' : 'none';
        });
    }

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
