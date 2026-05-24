@extends(auth()->user()->role === 'siswa' ? 'layouts.siswa' : (auth()->user()->role === 'tutor' ? 'layouts.tutor' : 'layouts.app'))

@section('title', 'Pengaturan Profil')

@section('content')
<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<div class="flex justify-between items-end mb-8">
    <div>
        <h2 class="font-headline font-extrabold text-3xl tracking-tight text-blue-900 dark:text-blue-100">Pengaturan Profil</h2>
        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 mt-1">Kelola identitas dan keamanan akun Anda</p>
    </div>
</div>

@if (session('status') === 'profile-updated')
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
        Profil berhasil diperbarui.
    </div>
@endif

@if (session('status') === 'password-updated')
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">check_circle</span>
        Kata sandi berhasil diperbarui.
    </div>
@endif

<div class="grid grid-cols-12 gap-8">
    <!-- Profil Pribadi -->
    <section class="col-span-12 lg:col-span-8 bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
        <div class="flex items-center justify-between mb-8">
            <h3 class="font-headline text-2xl font-bold text-slate-800 dark:text-slate-100 flex items-center">
                <span class="material-symbols-outlined mr-3 text-blue-600" style="font-variation-settings: 'FILL' 1;">person</span>
                Profil Pribadi
            </h3>
        </div>
        
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
            <div class="flex flex-col md:flex-row gap-10">
                <div class="flex-shrink-0">
                    <div class="w-28 h-28 lg:w-32 lg:h-32 rounded-3xl overflow-hidden ring-4 ring-blue-50 dark:ring-blue-900/20 bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-5xl font-black shadow-inner">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
                
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama Lengkap</label>
                        <input name="name" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700 dark:text-slate-200" value="{{ old('name', $user->name) }}" required/>
                        @error('name')<p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Email Institusi</label>
                        <input name="email" type="email" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700 dark:text-slate-200" value="{{ old('email', $user->email) }}" required/>
                        @error('email')<p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>

                    @if(in_array($user->role, ['tutor', 'siswa']))
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nomor Telepon</label>
                        <input name="no_hp" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium text-slate-700 dark:text-slate-200" value="{{ old('no_hp', $user->role === 'tutor' ? ($user->tutor->no_hp ?? '') : ($user->siswa->no_hp ?? '')) }}"/>
                        @error('no_hp')<p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                    @endif

                    <div class="space-y-2 {{ in_array($user->role, ['tutor', 'siswa']) ? '' : 'md:col-span-2' }}">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Jabatan / Role</label>
                        <div class="w-full bg-slate-100 dark:bg-slate-800/50 border-none rounded-xl px-4 py-3 text-slate-500 cursor-not-allowed font-bold capitalize flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">badge</span>
                            {{ $user->role }}
                        </div>
                    </div>
                    
                    @if(in_array($user->role, ['tutor', 'siswa']))
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Alamat Domisili</label>
                        <textarea name="alamat" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-blue-500/20 transition-all font-medium resize-none text-slate-700 dark:text-slate-200" rows="3">{{ old('alamat', $user->role === 'tutor' ? ($user->tutor->alamat ?? '') : ($user->siswa->alamat ?? '')) }}</textarea>
                        @error('alamat')<p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <!-- Map Location Edit -->
                    <div class="md:col-span-2 space-y-2 mt-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Tandai Lokasi Rumah Anda</label>
                            <button type="button" onclick="getLocation()" class="text-xs font-bold text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">my_location</span>
                                Gunakan GPS
                            </button>
                        </div>
                        <div id="map" class="w-full h-64 rounded-xl border-2 border-slate-200 dark:border-slate-700 z-0 relative"></div>
                        <p class="text-[11px] text-slate-500 px-1 mt-1">Geser pin merah atau klik peta untuk menyesuaikan titik lokasi rumah Anda secara akurat.</p>
                        
                        @php
                            $lat = $user->role === 'tutor' ? ($user->tutor->latitude ?? '') : ($user->siswa->latitude ?? '');
                            $lng = $user->role === 'tutor' ? ($user->tutor->longitude ?? '') : ($user->siswa->longitude ?? '');
                        @endphp
                        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $lat) }}">
                        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $lng) }}">
                    </div>
                    @endif
                    
                    <div class="md:col-span-2 mt-6 flex justify-end">
                        <button type="submit" class="bg-gradient-to-br from-blue-600 to-blue-800 text-white px-8 py-3 rounded-xl font-headline font-bold text-sm shadow-lg shadow-blue-500/30 hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <!-- Keamanan / Ubah Kata Sandi -->
    <section class="col-span-12 lg:col-span-4 bg-slate-50 dark:bg-slate-800/50 rounded-3xl p-8 flex flex-col border border-slate-100 dark:border-slate-700/50">
        <h3 class="font-headline text-xl font-bold text-slate-800 dark:text-slate-100 mb-6 flex items-center">
            <span class="material-symbols-outlined mr-3 text-blue-600" style="font-variation-settings: 'FILL' 1;">lock</span>
            Ubah Kata Sandi
        </h3>
        
        <form method="POST" action="{{ route('password.update') }}" class="flex-1 flex flex-col gap-5">
            @csrf
            @method('put')
            
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Kata Sandi Saat Ini</label>
                <input name="current_password" type="password" class="w-full bg-white dark:bg-slate-900 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium placeholder:text-slate-300" placeholder="••••••••" required/>
                @error('current_password', 'updatePassword')<p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
            
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Kata Sandi Baru</label>
                <input name="password" type="password" class="w-full bg-white dark:bg-slate-900 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium placeholder:text-slate-300" placeholder="••••••••" required/>
                @error('password', 'updatePassword')<p class="text-xs text-red-500 mt-1 font-bold">{{ $message }}</p>@enderror
            </div>
            
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Konfirmasi Kata Sandi</label>
                <input name="password_confirmation" type="password" class="w-full bg-white dark:bg-slate-900 border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500/20 transition-all font-medium placeholder:text-slate-300" placeholder="••••••••" required/>
            </div>
            
            <div class="mt-auto pt-6">
                <button type="submit" class="w-full bg-blue-100 text-blue-700 hover:bg-blue-600 hover:text-white px-6 py-3 rounded-xl font-headline font-bold text-sm transition-all duration-300 flex justify-center items-center gap-2">
                    <span class="material-symbols-outlined text-sm">key</span>
                    Perbarui Sandi
                </button>
            </div>
            
            <div class="mt-4 p-4 bg-amber-50 rounded-xl border border-amber-100 flex gap-3">
                <span class="material-symbols-outlined text-amber-500 text-lg">info</span>
                <p class="text-[11px] text-amber-700 font-medium leading-relaxed">
                    Kami sarankan untuk menggunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal.
                </p>
            </div>
        </form>
    </section>

    <!-- Notifikasi -->
    <section class="col-span-12 lg:col-span-6 bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
        <h3 class="font-headline text-xl font-bold text-slate-800 dark:text-slate-100 mb-8 flex items-center">
            <span class="material-symbols-outlined mr-3 text-blue-600" style="font-variation-settings: 'FILL' 1;">notifications_active</span>
            Notifikasi
        </h3>
        <div class="space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <p class="font-bold text-sm text-slate-700 dark:text-slate-200">Laporan Harian Email</p>
                    <p class="text-xs text-slate-500">Terima ringkasan aktivitas siswa setiap pagi</p>
                </div>
                <div class="relative inline-flex items-center cursor-pointer">
                    <input checked class="sr-only peer" type="checkbox"/>
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </div>
            </div>
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <p class="font-bold text-sm text-slate-700 dark:text-slate-200">Push Notifications Browser</p>
                    <p class="text-xs text-slate-500">Peringatan real-time untuk pesan baru pengajar</p>
                </div>
                <div class="relative inline-flex items-center cursor-pointer">
                    <input checked class="sr-only peer" type="checkbox"/>
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-bold text-sm text-slate-700 dark:text-slate-200">Pengingat Pembayaran</p>
                    <p class="text-xs text-slate-500">Notifikasi saat jatuh tempo administrasi siswa</p>
                </div>
                <div class="relative inline-flex items-center cursor-pointer">
                    <input class="sr-only peer" type="checkbox"/>
                    <div class="w-11 h-6 bg-slate-200 dark:bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Preferensi Sistem -->
    <section class="col-span-12 lg:col-span-6 bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-sm border border-slate-100 dark:border-slate-800">
        <h3 class="font-headline text-xl font-bold text-slate-800 dark:text-slate-100 mb-8 flex items-center">
            <span class="material-symbols-outlined mr-3 text-blue-600" style="font-variation-settings: 'FILL' 1;">display_settings</span>
            Preferensi Sistem
        </h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-3">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Bahasa</label>
                <div class="relative">
                    <select class="w-full appearance-none bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 font-medium text-slate-700 dark:text-slate-200 pr-10 focus:ring-2 focus:ring-blue-500/20">
                        <option selected>Bahasa Indonesia</option>
                        <option>English (US)</option>
                        <option>English (UK)</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                </div>
            </div>
            <div class="space-y-3">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Zona Waktu</label>
                <div class="relative">
                    <select class="w-full appearance-none bg-slate-50 dark:bg-slate-800 border-none rounded-xl px-4 py-3 font-medium text-slate-700 dark:text-slate-200 pr-10 focus:ring-2 focus:ring-blue-500/20">
                        <option selected>WIB (GMT+7)</option>
                        <option>WITA (GMT+8)</option>
                        <option>WIT (GMT+9)</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">schedule</span>
                </div>
            </div>
            <div class="col-span-2 space-y-3 mt-4">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tampilan Tema</label>
                <div class="grid grid-cols-3 gap-3">
                    <button class="flex flex-col items-center justify-center p-4 rounded-2xl bg-white dark:bg-slate-800 ring-2 ring-blue-500 transition-all group">
                        <span class="material-symbols-outlined text-blue-600 mb-2" style="font-variation-settings: 'FILL' 1;">light_mode</span>
                        <span class="text-xs font-bold text-blue-600">Terang</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 rounded-2xl bg-slate-900 border border-slate-800 hover:border-slate-700 transition-all group">
                        <span class="material-symbols-outlined text-slate-400 mb-2 group-hover:text-white transition-colors">dark_mode</span>
                        <span class="text-xs font-bold text-slate-400 group-hover:text-white transition-colors">Gelap</span>
                    </button>
                    <button class="flex flex-col items-center justify-center p-4 rounded-2xl bg-slate-100 dark:bg-slate-800/50 border border-transparent hover:border-slate-300 dark:hover:border-slate-600 transition-all group">
                        <span class="material-symbols-outlined text-slate-400 mb-2 group-hover:text-slate-600 dark:group-hover:text-slate-200 transition-colors">contrast</span>
                        <span class="text-xs font-bold text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-200 transition-colors">Otomatis</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

@if(in_array($user->role, ['tutor', 'siswa']))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var defaultLat = -6.200000;
        var defaultLng = 106.816666;

        var latInput = document.getElementById('latitude');
        var lngInput = document.getElementById('longitude');

        var isLocationSet = (latInput.value && lngInput.value);

        if(isLocationSet) {
            defaultLat = parseFloat(latInput.value);
            defaultLng = parseFloat(lngInput.value);
        }

        var map = L.map('map').setView([defaultLat, defaultLng], isLocationSet ? 16 : 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            latInput.value = position.lat;
            lngInput.value = position.lng;
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat;
            lngInput.value = e.latlng.lng;
        });

        if(!isLocationSet) {
            latInput.value = defaultLat;
            lngInput.value = defaultLng;
        }

        window.getLocation = function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    
                    map.setView([lat, lng], 16);
                    marker.setLatLng([lat, lng]);
                    
                    latInput.value = lat;
                    lngInput.value = lng;
                }, function(error) {
                    alert('Gagal mendeteksi lokasi. Pastikan izin akses lokasi aktif pada browser Anda.');
                });
            } else {
                alert('Browser Anda tidak mendukung deteksi lokasi.');
            }
        }
    });
</script>
@endif

@endsection
