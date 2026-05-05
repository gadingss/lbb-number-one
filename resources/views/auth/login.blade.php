<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - LBB Number One</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .brand-font { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-background min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Decorative Architectural Elements (Atelier Aesthetic) -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary-container/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-secondary-container/5 rounded-full blur-3xl"></div>
        <!-- Abstract Line Patterns (Zero-Line Fallback) -->
        <div class="absolute top-1/4 right-10 w-64 h-[1px] bg-outline-variant/10 rotate-45"></div>
        <div class="absolute top-1/3 right-20 w-48 h-[1px] bg-outline-variant/10 rotate-45"></div>
    </div>

    <!-- Login Container -->
    <main class="w-full max-w-[1100px] grid md:grid-cols-2 bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_12px_32px_-4px_rgba(13,28,46,0.06)] relative z-10">
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
                    Pusat Pembelajaran <br/>
                    <span class="text-primary">Eksklusif & Private</span>
                </h1>
                <p class="text-on-surface-variant text-lg leading-relaxed max-w-md">Selamat datang di LBB Number One. Kami menyediakan pengalaman belajar privat terbaik dengan tutor ahli berpengalaman.</p>
            </div>
            
            <div class="mt-auto relative z-10">
                <div class="bg-surface-container-lowest/60 backdrop-blur-md p-6 rounded-xl border border-white/20">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-10 h-10 rounded-full bg-primary-fixed text-primary flex items-center justify-center font-bold shadow-sm">
                            <span class="material-symbols-outlined text-xl">menu_book</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-on-surface">Pendidikan Kelas Atas</p>
                            <p class="text-xs text-on-surface-variant">Sistem terintegrasi untuk siswa dan pengajar.</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden">
                            <div class="h-full w-full bg-primary rounded-full relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                            </div>
                        </div>
                        <p class="text-[10px] uppercase tracking-wider font-bold text-primary">Sistem Selalu Siap</p>
                    </div>
                </div>
            </div>
            
            <!-- Background Decorative Image -->
            <div class="absolute inset-0 z-0 opacity-10">
                <img class="w-full h-full object-cover" data-alt="Minimalist architectural details of a modern university building" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA-aaLkC2-DcCC-RpsETTifaw3diB9IDde8pUFUcMgfX7TGZYAlIbyTYksbbXBhSD_ObuHSOOkvs1w1lEjBkQlX6rMXDdX4VGr7xd7ZqMQ-7MGTWQBMPLecAxTgBXfT1xjWUFR24v5nOVZYk7Df0uXTEmiEWg2xibkgK1BeTSY0GPZmORm5WI9KOlhf92YKevi-oz38YmH9KTOTDe5Jh3mAa9FNRgaQBnD5bnAwnSPrKAyr2Thv5R_q9RIc1iXEFVRCyXZKus9b6Wmg"/>
            </div>
        </section>

        <!-- Form Side -->
        <section class="p-8 md:p-16 flex flex-col justify-center">
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-on-surface mb-2">Masuk ke Sistem</h2>
                <p class="text-on-surface-variant">Silakan masukkan email dan password Anda untuk masuk.</p>
            </div>
            
            <x-auth-session-status class="mb-4 text-emerald-600 text-sm font-semibold" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <!-- Kode Login -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-on-surface-variant ml-1" for="kode">Kode Login (Siswa / Tutor)</label>
                    <div class="relative flex flex-col">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                            <span class="material-symbols-outlined text-outline text-lg">badge</span>
                        </div>
                        <input class="w-full pl-11 pr-4 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                            id="kode" 
                            name="kode" 
                            type="text" 
                            value="{{ old('kode') }}" 
                            required autofocus autocomplete="username"
                            placeholder="Masukkan kode login Anda"/>
                        <x-input-error :messages="$errors->get('kode')" class="mt-2 text-error text-xs font-semibold" />
                    </div>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-sm font-semibold text-on-surface-variant" for="password">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-bold text-primary hover:text-primary-container transition-colors" href="{{ route('password.request') }}">Lupa Password?</a>
                        @endif
                    </div>
                    <div class="relative flex flex-col">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none h-[52px]">
                            <span class="material-symbols-outlined text-outline text-lg">lock</span>
                        </div>
                        <input class="w-full pl-11 pr-12 py-3.5 bg-surface-container-highest border-0 rounded-xl focus:ring-2 focus:ring-primary-fixed focus:bg-surface-container-lowest transition-all duration-200 text-on-surface placeholder:text-outline/60" 
                            id="password" 
                            name="password" 
                            type="password" 
                            required autocomplete="current-password"
                            placeholder="••••••••"/>
                        
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-error text-xs font-semibold" />
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center space-x-3 px-1 mt-4">
                    <input class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary transition-all cursor-pointer bg-surface-container-highest" 
                        id="remember_me" name="remember" type="checkbox"/>
                    <label class="text-sm font-medium text-on-surface-variant cursor-pointer" for="remember_me">Ingat saya selama sesi ini</label>
                </div>

                <!-- Action Button -->
                <button class="w-full py-4 px-6 bg-gradient-to-br from-primary to-primary-container text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/30 active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 group mt-8" type="submit">
                    <span>Masuk</span>
                    <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>

            <!-- Registration Footer Link -->
            <div class="mt-12 text-center border-t border-outline-variant/20 pt-6">
                <p class="text-on-surface-variant text-sm">
                    Belum menjadi bagian dari kami? 
                    <a class="text-primary font-bold ml-1 hover:underline underline-offset-4 decoration-2" href="{{ route('register') }}">Daftar Sekarang</a>
                </p>
            </div>
        </section>
    </main>
</body>
</html>
