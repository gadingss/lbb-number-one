@extends('layouts.app')

@section('title', 'Tutor Scheduling')

@section('content')
<div class="grid grid-cols-12 gap-8 max-w-7xl mx-auto">
    <!-- Left Column: Scheduler Form and Table -->
    <div class="col-span-12 space-y-8">
        
        <!-- Page Title -->
        <div class="flex flex-col gap-1">
            <h2 class="text-3xl font-extrabold text-blue-900 tracking-tight font-headline">Tutor Scheduling</h2>
            <p class="text-slate-500 font-medium">Orchestrate and optimize learning sessions with precision.</p>
        </div>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create New Schedule Form -->
        <section class="bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/15">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-8 h-8 rounded-lg bg-primary-fixed flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-sm" data-icon="edit_calendar">edit_calendar</span>
                </div>
                <h3 class="text-lg font-bold text-on-background font-headline">Create New Schedule</h3>
            </div>
            
            <form action="{{ route('admin.jadwal.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Tutor</label>
                    <select name="tutor_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 appearance-none" required>
                        <option value="">Select a Tutor</option>
                        @foreach($tutors as $tutor)
                            @php
                                $activeCount = $tutor->active_students_count;
                                $kuota = $tutor->kuota_siswa;
                                $isFull = $activeCount >= $kuota;
                                $isSelected = old('tutor_id') == $tutor->id;
                            @endphp
                            <option value="{{ $tutor->id }}" 
                                {{ $isFull ? 'disabled' : '' }}
                                {{ $isSelected ? 'selected' : '' }}
                                class="{{ $isFull ? 'text-gray-400 bg-gray-100' : 'text-gray-900' }}"
                                style="{{ $isFull ? 'color: #9ca3af; background-color: #f3f4f6;' : '' }}">
                                {{ $tutor->user->name }} 
                                @if($isFull)
                                    (Kuota Penuh: {{ $activeCount }}/{{ $kuota }})
                                @else
                                    (Sisa Kuota: {{ $kuota - $activeCount }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('tutor_id')
                        <p class="text-red-500 text-xs italic mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Subject</label>
                    <select name="mata_pelajaran_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 appearance-none" required>
                        <option value="">Select Subject</option>
                        @foreach($mapels as $mapel)
                            <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Siswa</label>
                    <select name="siswa_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 appearance-none" required>
                        <option value="">Select Siswa</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>{{ $siswa->user->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Day of Week</label>
                    <select name="hari" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20 appearance-none" required>
                        <option value="">Select Day</option>
                        <option value="Senin" {{ old('hari') == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('hari') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('hari') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('hari') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('hari') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ old('hari') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        <option value="Minggu" {{ old('hari') == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Start Time</label>
                        <input name="jam_mulai" value="{{ old('jam_mulai') }}" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" type="time" required/>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">End Time</label>
                        <input name="jam_selesai" value="{{ old('jam_selesai') }}" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-primary/20" type="time" required/>
                    </div>
                </div>
                
                <div class="md:col-span-2 flex justify-end pt-2">
                    <button class="bg-gradient-to-br from-primary to-primary-container text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg active:scale-95 transition-all" type="submit">
                        Generate Schedule Entry
                    </button>
                </div>
            </form>
        </section>

        <!-- Weekly Overview Table -->
        <section class="bg-surface-container-low rounded-xl overflow-hidden shadow-sm border border-outline-variant/15">
            <div class="p-6 flex justify-between items-center bg-white border-b border-outline-variant/10">
                <h3 class="text-lg font-bold text-on-background font-headline">Weekly Overview</h3>
                <div class="flex gap-2">
                    <button class="p-2 rounded-lg hover:bg-slate-100 text-slate-500"><span class="material-symbols-outlined" data-icon="filter_list">filter_list</span></button>
                    <button class="p-2 rounded-lg hover:bg-slate-100 text-slate-500"><span class="material-symbols-outlined" data-icon="download">download</span></button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-high">
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Tutor</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Siswa</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Subject</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Day</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em]">Time Window</th>
                            <th class="px-6 py-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.1em] text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100/50">
                        @php
                            $colors = ['bg-blue-100 text-blue-600', 'bg-purple-100 text-purple-600', 'bg-orange-100 text-orange-600', 'bg-green-100 text-green-600'];
                            $badgeColors = ['bg-primary-fixed text-on-primary-fixed', 'bg-tertiary-fixed text-on-tertiary-fixed', 'bg-surface-variant text-on-surface-variant'];
                        @endphp
                        
                        @forelse($jadwals as $index => $jadwal)
                            @php
                                $colorClass = $colors[$index % count($colors)];
                                $badgeClass = $badgeColors[$index % count($badgeColors)];
                                $initials = collect(explode(' ', $jadwal->tutor->user->name ?? 'U N'))->map(function($word) { return strtoupper(substr($word, 0, 1)); })->take(2)->join('');
                            @endphp
                            <tr class="group hover:bg-surface-container-lowest transition-colors bg-white/40">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full {{ $colorClass }} flex items-center justify-center font-bold text-xs">
                                            {{ $initials }}
                                        </div>
                                        <span class="text-sm font-semibold text-on-background">{{ $jadwal->tutor->user->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm font-medium text-slate-700">{{ $jadwal->siswa->user->name ?? 'Belum Diatur' }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 rounded-full {{ $badgeClass }} text-[10px] font-bold uppercase tracking-wide">
                                        {{ $jadwal->mataPelajaran->nama_mapel }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-sm text-slate-600">{{ $jadwal->hari }}</td>
                                <td class="px-6 py-5 text-sm font-medium text-blue-700">
                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('h:i A') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('h:i A') }}
                                </td>
                                <td class="px-6 py-5 text-right flex justify-end gap-2">
                                    <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="text-slate-400 hover:text-blue-600 transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
                                    </a>
                                    <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors" title="Delete">
                                            <span class="material-symbols-outlined text-lg" data-icon="delete">delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-500 font-medium">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-4xl text-slate-300" data-icon="event_busy">event_busy</span>
                                        <p>Belum ada jadwal yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>

</div>
@endsection
