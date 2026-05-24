@extends('layouts.siswa')

@section('title', 'Pilih Tutor dan Jadwal')

@section('content')
<section class="max-w-4xl mx-auto mb-12">
    <div class="mb-8">
        <a href="{{ route('siswa.paket.index') }}" class="text-primary hover:underline flex items-center gap-2 mb-4">
            <span class="material-symbols-outlined text-sm">arrow_back</span> Kembali ke Daftar Paket
        </a>
        <h2 class="font-headline text-3xl font-extrabold text-on-surface mb-2">Pilih Tutor & Jadwal</h2>
        <p class="text-on-surface-variant">Paket: <strong class="text-primary">{{ $paket->nama_paket }}</strong> ({{ $paket->jumlah_pertemuan }}x Pertemuan)</p>
        <p class="text-on-surface-variant text-sm mt-1">Anda dapat memilih jadwal rutin (maksimal <strong class="text-primary">{{ $kuotaJadwal }} slot per minggu</strong>) sesuai kebutuhan Anda hingga paket habis.</p>
    </div>

    <form action="{{ route('siswa.paket.pesan') }}" method="POST" id="form-pesan-jadwal">
        @csrf
        <input type="hidden" name="paket_id" value="{{ $paket->id }}">

        <!-- 1. Pilih Tutor -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant/20 shadow-sm mb-6">
            <h3 class="text-xl font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">person_search</span> 1. Pilih Tutor
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($tutors as $index => $tutor)
                <label class="cursor-pointer relative">
                    <input type="radio" name="tutor_id" value="{{ $tutor->id }}" class="peer hidden" required onchange="fetchSchedules(this.value)" {{ $index == 0 ? 'checked' : '' }}>
                    <div class="p-4 rounded-xl border-2 border-outline-variant/30 peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/50 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-surface-container-highest flex items-center justify-center text-on-surface-variant overflow-hidden">
                                @if($tutor->user && $tutor->user->avatar)
                                    <img src="{{ Storage::url($tutor->user->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined">person</span>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-on-surface">{{ $tutor->user->name ?? 'Tutor' }}</h4>
                                <p class="text-xs text-on-surface-variant line-clamp-1">{{ $tutor->keahlian ?? 'Umum' }}</p>
                            </div>
                        </div>
                    </div>
                </label>
                @empty
                <div class="col-span-full p-4 text-center text-on-surface-variant bg-surface-container-low rounded-xl">
                    Belum ada tutor yang tersedia untuk mata pelajaran ini.
                </div>
                @endforelse
            </div>
        </div>

        <!-- 2. Pilih Jadwal -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant/20 shadow-sm mb-8" id="jadwal-container" style="opacity: 0.5; pointer-events: none;">
            <h3 class="text-xl font-bold text-on-surface mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">calendar_month</span> 2. Pilih Jadwal Mingguan
            </h3>
            <p class="text-sm text-on-surface-variant mb-6">Pilih slot jadwal kosong. Slot yang berwarna abu-abu sudah diisi oleh siswa lain.</p>

            @php
                $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
                $jamList = ['15:00-17:00', '18:00-20:00'];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($hariList as $hari)
                    <div class="flex flex-col gap-3">
                        <div class="text-center font-bold text-on-surface py-2 bg-surface-container-low rounded-lg">{{ $hari }}</div>
                        
                        @foreach($jamList as $jam)
                            @php
                                $slotValue = $hari . '|' . $jam;
                            @endphp
                            <label class="cursor-pointer slot-label" data-hari="{{ $hari }}" data-jam="{{ explode('-', $jam)[0] . ':00' }}">
                                <input type="checkbox" name="jadwals[]" value="{{ $slotValue }}" class="peer hidden slot-checkbox" onchange="checkQuota(this)">
                                <div class="p-3 text-center rounded-xl border border-outline-variant/30 text-sm font-medium transition-all
                                    peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary peer-disabled:opacity-50 peer-disabled:cursor-not-allowed peer-disabled:bg-surface-container-high
                                    hover:border-primary hover:bg-primary/5
                                ">
                                    {{ $jam }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" id="btn-submit" class="px-8 py-4 bg-primary text-white rounded-xl font-bold shadow-lg hover:scale-105 transition-transform disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100" disabled>
                Lanjutkan ke Pembayaran
            </button>
        </div>
    </form>
</section>

@section('scripts')
<script>
    const maxSlots = {{ $kuotaJadwal }};
    const jadwalContainer = document.getElementById('jadwal-container');
    const submitBtn = document.getElementById('btn-submit');
    
    function fetchSchedules(tutorId) {
        // Enable schedule container
        jadwalContainer.style.opacity = '1';
        jadwalContainer.style.pointerEvents = 'auto';
        
        // Reset all checkboxes except those taken by Siswa themselves
        const jadwalSiswa = @json($jadwalSiswa);
        
        document.querySelectorAll('.slot-checkbox').forEach(cb => {
            cb.checked = false;
            cb.disabled = false;
            
            // Check if Siswa already has this slot taken
            const label = cb.closest('label');
            const hari = label.dataset.hari;
            const jam = label.dataset.jam;
            
            const isTakenBySiswa = jadwalSiswa.some(j => j.hari === hari && j.jam_mulai === jam);
            if(isTakenBySiswa) {
                cb.disabled = true; // Mark as taken by Siswa themselves
                // Optionally visually indicate it's the Siswa's own class
                label.querySelector('div').classList.add('bg-error/10', 'border-error/30', 'text-error');
                label.querySelector('div').title = 'Bentrok dengan jadwal Anda yang lain';
            } else {
                label.querySelector('div').classList.remove('bg-error/10', 'border-error/30', 'text-error');
                label.querySelector('div').title = '';
            }
        });
        updateSubmitButton();

        // Fetch taken schedules
        fetch(`/siswa/paket/tutor-schedules/${tutorId}`)
            .then(response => response.json())
            .then(data => {
                // data format: [{hari: "Senin", jam_mulai: "15:00:00", jam_selesai: "17:00:00"}]
                data.forEach(schedule => {
                    const label = document.querySelector(`.slot-label[data-hari="${schedule.hari}"][data-jam="${schedule.jam_mulai}"]`);
                    if (label) {
                        const cb = label.querySelector('.slot-checkbox');
                        if (cb) {
                            cb.disabled = true; // Mark as taken
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching schedules:', error));
    }

    function checkQuota(checkbox) {
        const checkedCount = document.querySelectorAll('.slot-checkbox:checked').length;
        
        if (checkedCount > maxSlots) {
            checkbox.checked = false;
            alert(`Anda hanya dapat memilih maksimal ${maxSlots} slot jadwal.`);
        }
        
        updateSubmitButton();
    }

    function updateSubmitButton() {
        const checkedCount = document.querySelectorAll('.slot-checkbox:checked').length;
        const tutorSelected = document.querySelector('input[name="tutor_id"]:checked') !== null;
        
        // Allow submission if tutor selected and at least 1 schedule selected
        if (tutorSelected && checkedCount > 0) {
            submitBtn.disabled = false;
        } else {
            submitBtn.disabled = true;
        }
    }

    // Auto-fetch for initially selected tutor
    document.addEventListener("DOMContentLoaded", () => {
        const selectedTutor = document.querySelector('input[name="tutor_id"]:checked');
        if (selectedTutor) {
            fetchSchedules(selectedTutor.value);
        }
    });
</script>
@endsection
@endsection
