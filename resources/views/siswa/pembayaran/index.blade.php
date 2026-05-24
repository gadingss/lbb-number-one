@extends('layouts.siswa')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-headline font-extrabold text-on-surface mb-2">Riwayat Pembayaran</h2>
        <p class="text-on-surface-variant font-medium">Daftar riwayat tagihan dan pembayaran paket Anda</p>
    </div>

    <div class="bg-surface-container-lowest rounded-[1.5rem] shadow-[0_8px_24px_-4px_rgba(13,28,46,0.04)] border border-outline-variant/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[700px]">
                <thead class="bg-surface-container-high/50 border-b border-outline-variant/20">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Order ID</th>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Paket</th>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-bold tracking-[0.1em] text-on-surface-variant uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/15">
                    @forelse($pembayarans as $pembayaran)
                    <tr class="hover:bg-surface-container-low transition-colors group">
                        <td class="px-6 py-5 font-mono text-xs text-on-surface-variant">{{ $pembayaran->order_id ?? '-' }}</td>
                        <td class="px-6 py-5 font-medium text-sm text-on-surface">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}</td>
                        <td class="px-6 py-5">
                            <p class="font-bold text-on-surface">{{ $pembayaran->paket->nama_paket ?? '-' }}</p>
                            <p class="text-xs text-on-surface-variant">{{ $pembayaran->paket->mataPelajaran->nama_mapel ?? 'Umum' }}</p>
                        </td>
                        <td class="px-6 py-5 font-bold text-on-surface">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-5">
                            @if($pembayaran->status == 'lunas')
                                <span class="px-3 py-1 rounded-full bg-primary-fixed text-on-primary-fixed text-[10px] font-black uppercase tracking-wider">Lunas</span>
                            @elseif($pembayaran->status == 'pending')
                                <span class="px-3 py-1 rounded-full bg-surface-container-highest text-on-surface-variant text-[10px] font-black uppercase tracking-wider">Menunggu</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-error-container text-on-error-container text-[10px] font-black uppercase tracking-wider">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl block mb-2 opacity-50">receipt_long</span>
                            Belum ada riwayat pembayaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-outline-variant/20">
            {{ $pembayarans->links() }}
        </div>
    </div>
</div>
@endsection
