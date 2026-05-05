<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Register - LBB Number One</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .brand-font { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Custom scrollbar for form area if it gets too long */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        .overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }
    </style>
</head>
<body class="bg-surface text-on-background min-h-screen flex items-center justify-center p-6 md:p-12 relative overflow-x-hidden">
    <!-- Decorative Architectural Elements (Atelier Aesthetic) -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary-container/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-secondary-container/5 rounded-full blur-3xl"></div>
        <!-- Abstract Line Patterns (Zero-Line Fallback) -->
        <div class="absolute top-1/4 right-10 w-64 h-[1px] bg-outline-variant/10 rotate-45"></div>
        <div class="absolute top-1/3 right-20 w-48 h-[1px] bg-outline-variant/10 rotate-45"></div>
    </div>

    <!-- Register Container -->
    <main class="w-full max-w-[1100px] grid md:grid-cols-2 bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] relative z-10 my-8">
        
        <!-- Branding & Visual Side -->
        <section class="hidden md:flex flex-col justify-between p-12 bg-surface-container-low relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-12">
                    <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-white shadow-sm" style="font-variation-settings: 'FILL' 1;">school</span>
                    </div>
                    <div>
                        <span class="brand-font text-xl font-bold tracking-tight text-blue-900 block leading-none">LBB Number One</span>
                        <span class="text-[10px] uppercase tracking-widest text-primary/70 font-semibold">Les Bimbel Private</span>
                    </div>
                </div>
                
                <h1 class="text-4xl font-extrabold text-on-surface leading-tight mb-6">
                    Mulai Perjalanan <br/>
                    <span class="text-primary">Pendidikan Anda</span>
                </h1>
                <p class="text-on-surface-variant text-lg leading-relaxed max-w-md">Bergabunglah dengan LBB Number One. Daftarkan diri Anda sebagai siswa untuk mulai belajar, atau sebagai tutor untuk mulai mengajar.</p>
            </div>
            
            <div class="mt-auto relative z-10">
                <div class="bg-surface-container-lowest/60 backdrop-blur-md p-6 rounded-xl border border-white/20">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold shadow-sm">
                            <span class="material-symbols-outlined text-xl">person_add</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-on-surface">Pendaftaran Mudah</p>
                            <p class="text-xs text-on-surface-variant">Lengkapi profil Anda untuk akses penuh.</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden">
                            <div class="h-full w-full bg-primary rounded-full relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                            </div>
                        </div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-primary">Proses Aman & Cepat</p>
                    </div>
                </div>
            </div>
            
            <!-- Background Decorative Image -->
            <div class="absolute inset-0 z-0 opacity-10">
                <img class="w-full h-full object-cover" data-alt="Minimalist architectural details of a modern university building" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA-aaLkC2-DcCC-RpsETTifaw3diB9IDde8pUFUcMgfX7TGZYAlIbyTYksbbXBhSD_ObuHSOOkvs1w1lEjBkQlX6rMXDdX4VGr7xd7ZqMQ-7MGTWQBMPLecAxTgBXfT1xjWUFR24v5nOVZYk7Df0uXTEmiEWg2xibkgK1BeTSY0GPZmORm5WI9KOlhf92YKevi-oz38YmH9KTOTDe5Jh3mAa9FNRgaQBnD5bnAwnSPrKAyr2Thv5R_q9RIc1iXEFVRCyXZKus9b6Wmg"/>
            </div>
        </section>

        <!-- Form Side -->
        <section class="p-8 md:p-12 flex flex-col justify-center">
            <div class="mb-8 mt-4">
                <h2 class="text-2xl font-bold text-on-surface mb-2">Buat Akun Baru</h2>
                <p class="text-on-surface-variant">Silakan lengkapi form di bawah ini untuk mendaftar.</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" x-data="{ role: 'siswa' }" class="space-y-5 pb-4">
                @csrf
                
                <!-- Role -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface-variant ml-1" for="role">Daftar Sebagai</label>
                    <div class="relative flex flex-col">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                            <span class="material-symbols-outlined text-outline text-lg">group</span>
                        </div>
                        <select class="w-full pl-11 pr-10 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface appearance-none" 
                            id="role" name="role" x-model="role">
                            <option value="siswa">Siswa</option>
                            <option value="tutor">Tutor</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none h-[52px]">
                            <span class="material-symbols-outlined text-outline text-lg">expand_more</span>
                        </div>
                        <x-input-error :messages="$errors->get('role')" class="mt-2 text-error text-xs font-semibold" />
                    </div>
                </div>

                <!-- Name -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface-variant ml-1" for="name">Nama Lengkap</label>
                    <div class="relative flex flex-col">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                            <span class="material-symbols-outlined text-outline text-lg">person</span>
                        </div>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                            id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="John Doe"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-error text-xs font-semibold" />
                    </div>
                </div>

                <!-- Email Address -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface-variant ml-1" for="email">Email</label>
                    <div class="relative flex flex-col">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                            <span class="material-symbols-outlined text-outline text-lg">mail</span>
                        </div>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                            id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" placeholder="email@example.com"/>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-error text-xs font-semibold" />
                    </div>
                </div>

                <!-- No HP -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface-variant ml-1" for="no_hp">No HP (WhatsApp)</label>
                    <div class="relative flex flex-col">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                            <span class="material-symbols-outlined text-outline text-lg">phone</span>
                        </div>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                            id="no_hp" name="no_hp" type="text" value="{{ old('no_hp') }}" required placeholder="08123456789"/>
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-2 text-error text-xs font-semibold" />
                    </div>
                </div>

                <!-- Alamat -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface-variant ml-1" for="alamat">Alamat</label>
                    <div class="relative flex flex-col">
                        <div class="absolute top-0 left-0 pl-4 pt-3.5 flex items-start pointer-events-none">
                            <span class="material-symbols-outlined text-outline text-lg">location_on</span>
                        </div>
                        <textarea class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60 resize-none h-24" 
                            id="alamat" name="alamat" required placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2 text-error text-xs font-semibold" />
                    </div>
                </div>

                <!-- Map Location -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-sm font-semibold text-on-surface-variant" for="map">Tandai Titik Lokasi Rumah Anda</label>
                        <button type="button" onclick="getLocation()" class="text-xs font-bold text-primary hover:text-primary-container transition-colors flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">my_location</span>
                            Gunakan GPS
                        </button>
                    </div>
                    <div id="map" class="w-full h-48 rounded-xl border-2 border-surface-container-highest z-0"></div>
                    <p class="text-xs text-on-surface-variant px-1">Geser pin merah atau klik peta untuk menyesuaikan titik lokasi Anda.</p>
                    <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}">
                    <x-input-error :messages="$errors->get('latitude')" class="mt-1 text-error text-xs font-semibold" />
                    <x-input-error :messages="$errors->get('longitude')" class="mt-1 text-error text-xs font-semibold" />
                </div>

                <!-- Siswa Only -->
                <div x-show="role === 'siswa'" class="space-y-5" x-transition>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-on-surface-variant ml-1" for="sekolah">Asal Sekolah</label>
                        <div class="relative flex flex-col">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                                <span class="material-symbols-outlined text-outline text-lg">account_balance</span>
                            </div>
                            <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                                id="sekolah" name="sekolah" type="text" value="{{ old('sekolah') }}" placeholder="Nama Sekolah"/>
                            <x-input-error :messages="$errors->get('sekolah')" class="mt-2 text-error text-xs font-semibold" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-on-surface-variant ml-1" for="kelas">Kelas</label>
                        <div class="relative flex flex-col">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                                <span class="material-symbols-outlined text-outline text-lg">class</span>
                            </div>
                            <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                                id="kelas" name="kelas" type="text" value="{{ old('kelas') }}" placeholder="Contoh: 10 IPA"/>
                            <x-input-error :messages="$errors->get('kelas')" class="mt-2 text-error text-xs font-semibold" />
                        </div>
                    </div>
                </div>

                <!-- Tutor Only -->
                <div x-show="role === 'tutor'" style="display: none;" class="space-y-5" x-transition>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-on-surface-variant ml-1" for="keahlian">Keahlian (Mata Pelajaran)</label>
                        <div class="relative flex flex-col">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                                <span class="material-symbols-outlined text-outline text-lg">psychology</span>
                            </div>
                            <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                                id="keahlian" name="keahlian" type="text" value="{{ old('keahlian') }}" placeholder="Contoh: Matematika, Fisika"/>
                            <x-input-error :messages="$errors->get('keahlian')" class="mt-2 text-error text-xs font-semibold" />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-on-surface-variant ml-1" for="pendidikan_terakhir">Pendidikan Terakhir</label>
                        <div class="relative flex flex-col">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                                <span class="material-symbols-outlined text-outline text-lg">history_edu</span>
                            </div>
                            <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                                id="pendidikan_terakhir" name="pendidikan_terakhir" type="text" value="{{ old('pendidikan_terakhir') }}" placeholder="Contoh: S1 Matematika"/>
                            <x-input-error :messages="$errors->get('pendidikan_terakhir')" class="mt-2 text-error text-xs font-semibold" />
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface-variant ml-1" for="password">Password</label>
                    <div class="relative flex flex-col">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                            <span class="material-symbols-outlined text-outline text-lg">lock</span>
                        </div>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                            id="password" name="password" type="password" required autocomplete="new-password" placeholder="••••••••"/>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-error text-xs font-semibold" />
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface-variant ml-1" for="password_confirmation">Konfirmasi Password</label>
                    <div class="relative flex flex-col">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                            <span class="material-symbols-outlined text-outline text-lg">lock_reset</span>
                        </div>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                            id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="••••••••"/>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-error text-xs font-semibold" />
                    </div>
                </div>

                <!-- Action Button -->
                <button class="w-full py-4 px-6 bg-gradient-to-br from-primary to-primary-container text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 group mt-6" type="submit">
                    <span>Daftar Sekarang</span>
                    <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>

            <!-- Login Footer Link -->
            <div class="mt-6 text-center border-t border-outline-variant/20 pt-6">
                <p class="text-on-surface-variant text-sm">
                    Sudah memiliki akun? 
                    <a class="text-primary font-bold ml-1 hover:underline underline-offset-4 decoration-2" href="{{ route('login') }}">Masuk di sini</a>
                </p>
            </div>
        </section>
    </main>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Default ke pusat Indonesia atau Jakarta jika belum ada koordinat
        var defaultLat = -6.200000;
        var defaultLng = 106.816666;

        var latInput = document.getElementById('latitude');
        var lngInput = document.getElementById('longitude');

        if(latInput.value && lngInput.value) {
            defaultLat = parseFloat(latInput.value);
            defaultLng = parseFloat(lngInput.value);
        }

        var map = L.map('map').setView([defaultLat, defaultLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

        // Update inputs saat marker digeser
        marker.on('dragend', function(e) {
            var position = marker.getLatLng();
            latInput.value = position.lat;
            lngInput.value = position.lng;
        });

        // Klik di peta untuk memindah marker
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat;
            lngInput.value = e.latlng.lng;
        });

        // Initialize inputs jika kosong
        if(!latInput.value || !lngInput.value) {
            latInput.value = defaultLat;
            lngInput.value = defaultLng;
        }

        // Get Location using GPS
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
                    alert('Gagal mendeteksi lokasi. Pastikan Anda memberikan izin akses lokasi di browser Anda.');
                });
            } else {
                alert('Browser Anda tidak mendukung deteksi lokasi.');
            }
        }
    });
</script>
</html>
