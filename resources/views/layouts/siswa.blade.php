<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Dashboard Siswa') - LBB Number One</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom UI Fonts & Icons -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed": "#ffdbcd",
                        "surface-container-lowest": "#ffffff",
                        "tertiary": "#943700",
                        "on-surface": "#0d1c2e",
                        "on-surface-variant": "#434655",
                        "surface-tint": "#0053db",
                        "primary-fixed-dim": "#b4c5ff",
                        "on-tertiary-fixed": "#360f00",
                        "error": "#ba1a1a",
                        "inverse-surface": "#233144",
                        "inverse-on-surface": "#eaf1ff",
                        "surface-container": "#e6eeff",
                        "surface-container-low": "#eff4ff",
                        "tertiary-fixed-dim": "#ffb596",
                        "on-error-container": "#93000a",
                        "on-secondary": "#ffffff",
                        "secondary-fixed": "#dbe1ff",
                        "outline": "#737686",
                        "secondary-fixed-dim": "#b4c5ff",
                        "on-secondary-container": "#394c84",
                        "primary": "#004ac6",
                        "on-tertiary-fixed-variant": "#7d2d00",
                        "primary-fixed": "#dbe1ff",
                        "surface-dim": "#ccdbf3",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#eeefff",
                        "surface-container-highest": "#d5e3fc",
                        "on-primary": "#ffffff",
                        "surface-bright": "#f8f9ff",
                        "on-secondary-fixed": "#00174b",
                        "on-primary-fixed-variant": "#003ea8",
                        "tertiary-container": "#bc4800",
                        "surface-variant": "#d5e3fc",
                        "background": "#f8f9ff",
                        "on-tertiary-container": "#ffede6",
                        "secondary": "#495c95",
                        "surface-container-high": "#dce9ff",
                        "on-secondary-fixed-variant": "#31447b",
                        "inverse-primary": "#b4c5ff",
                        "on-background": "#0d1c2e",
                        "surface": "#f8f9ff",
                        "outline-variant": "#c3c6d7",
                        "on-error": "#ffffff",
                        "on-primary-fixed": "#00174b",
                        "secondary-container": "#acbfff",
                        "primary-container": "#2563eb",
                        "error-container": "#ffdad6"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "display": ["Manrope"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-headline { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* Sidebar transition */
        .sidebar-enter { transform: translateX(-100%); }
        .sidebar-open { transform: translateX(0); }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed">

<!-- Mobile Overlay Backdrop -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- SideNavBar Shell -->
<aside id="sidebar" class="h-screen w-64 fixed left-0 top-0 overflow-y-auto bg-surface-container-low dark:bg-surface-container-lowest z-50 flex flex-col gap-2 p-6 transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    <div class="mb-8 px-2 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg flex-shrink-0">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">school</span>
        </div>
        <div class="min-w-0">
            <h1 class="text-lg font-black text-primary dark:text-inverse-primary leading-tight">LBB Number One Management</h1>
            <p class="text-[10px] uppercase tracking-widest text-on-surface-variant/80 font-bold">Bimbingan Belajar Privat</p>
        </div>
        <!-- Close button (mobile only) -->
        <button onclick="toggleSidebar()" class="lg:hidden ml-auto -mr-2 w-8 h-8 rounded-full hover:bg-surface-container-high flex items-center justify-center transition-colors flex-shrink-0">
            <span class="material-symbols-outlined text-on-surface-variant text-lg">close</span>
        </button>
    </div>
    
    <nav class="flex flex-col gap-1">
        @php
            $route = Route::currentRouteName();
        @endphp

        <a class="{{ str_contains($route, 'siswa.dashboard') ? 'bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-md transform scale-105' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} rounded-xl flex items-center gap-4 p-4 transition-all duration-200" href="{{ route('siswa.dashboard') }}">
            <span class="material-symbols-outlined" {!! str_contains($route, 'siswa.dashboard') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>dashboard</span>
            <span class="font-headline text-sm font-bold">Dashboard</span>
        </a>
        
        <a class="{{ str_contains($route, 'siswa.paket') ? 'bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-md transform scale-105' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} rounded-xl flex items-center gap-4 p-4 transition-all duration-200" href="{{ route('siswa.paket.index') }}">
            <span class="material-symbols-outlined" {!! str_contains($route, 'siswa.paket') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>package</span>
            <span class="font-headline text-sm font-medium">Pilih Paket</span>
        </a>
        
        <a class="{{ str_contains($route, 'siswa.jadwal') ? 'bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-md transform scale-105' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} rounded-xl flex items-center gap-4 p-4 transition-all duration-200" href="{{ route('siswa.jadwal.index') }}">
            <span class="material-symbols-outlined" {!! str_contains($route, 'siswa.jadwal') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>calendar_month</span>
            <span class="font-headline text-sm font-medium">Jadwal Les</span>
        </a>
        
        <a class="{{ str_contains($route, 'siswa.pembayaran') ? 'bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-md transform scale-105' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} rounded-xl flex items-center gap-4 p-4 transition-all duration-200" href="{{ route('siswa.pembayaran.index') }}">
            <span class="material-symbols-outlined" {!! str_contains($route, 'siswa.pembayaran') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>receipt_long</span>
            <span class="font-headline text-sm font-medium">Riwayat Pembayaran</span>
        </a>

        <a class="{{ str_contains($route, 'siswa.riwayat') ? 'bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-md transform scale-105' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} rounded-xl flex items-center gap-4 p-4 transition-all duration-200" href="{{ route('siswa.riwayat.index') }}">
            <span class="material-symbols-outlined" {!! str_contains($route, 'siswa.riwayat') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>history</span>
            <span class="font-headline text-sm font-medium">Riwayat Les</span>
        </a>
        
        <a class="{{ str_contains($route, 'profile') ? 'bg-gradient-to-br from-primary to-primary-container text-on-primary shadow-md transform scale-105' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} rounded-xl flex items-center gap-4 p-4 transition-all duration-200" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined" {!! str_contains($route, 'profile') ? 'style="font-variation-settings: \'FILL\' 1;"' : '' !!}>person</span>
            <span class="font-headline text-sm font-medium">Profil Saya</span>
        </a>
    </nav>
    
    <div class="mt-auto bg-surface-container-high/40 rounded-2xl p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-primary-fixed flex items-center justify-center text-primary font-bold flex-shrink-0">
            {{ substr(auth()->user()->name, 0, 1) }}
        </div>
        <div class="overflow-hidden min-w-0">
            <p class="text-xs font-bold text-on-surface truncate">{{ auth()->user()->name }}</p>
            <p class="text-[10px] text-on-surface-variant">Siswa</p>
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="ml-auto flex-shrink-0">
            @csrf
            <button type="submit" class="text-on-surface-variant hover:text-error transition-colors" title="Logout">
                <span class="material-symbols-outlined text-lg">logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- TopAppBar Shell -->
<header class="fixed top-0 right-0 left-0 lg:left-64 h-16 z-30 bg-surface/80 backdrop-blur-xl flex justify-between items-center px-4 sm:px-6 lg:px-8">
    <div class="flex items-center gap-3">
        <!-- Hamburger button (mobile only) -->
        <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 rounded-full hover:bg-surface-container-high flex items-center justify-center transition-colors flex-shrink-0">
            <span class="material-symbols-outlined text-on-surface-variant">menu</span>
        </button>
        <h2 class="text-base sm:text-lg font-headline font-extrabold text-on-surface truncate">@yield('title', 'Dashboard Siswa')</h2>
    </div>
    
    <div class="flex items-center gap-2 sm:gap-4">
        <div class="relative group hidden sm:block">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="material-symbols-outlined text-outline text-sm">search</span>
            </div>
            <input class="bg-surface-container-high border-none rounded-full py-2 pl-10 pr-4 text-sm w-48 focus:ring-2 focus:ring-primary/20 focus:w-64 transition-all duration-300" placeholder="Cari materi..." type="text"/>
        </div>
        
        <button class="w-10 h-10 rounded-full hover:bg-surface-container-high flex items-center justify-center transition-colors">
            <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
        </button>
        
        <a href="{{ route('profile.edit') }}" class="w-10 h-10 rounded-full hover:bg-surface-container-high flex items-center justify-center transition-colors hidden sm:flex">
            <span class="material-symbols-outlined text-on-surface-variant">settings</span>
        </a>
    </div>
</header>

<!-- Main Canvas -->
<main class="lg:ml-64 pt-20 sm:pt-24 px-4 sm:px-6 lg:px-8 pb-12 min-h-screen">
    @yield('content')
</main>

<!-- FAB -->
<button class="fixed bottom-6 right-6 sm:bottom-10 sm:right-10 w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-primary to-primary-container text-white shadow-2xl flex items-center justify-center transform hover:scale-110 active:scale-95 transition-all duration-200 z-30">
    <span class="material-symbols-outlined text-2xl sm:text-3xl" style="font-variation-settings: 'FILL' 1;">add_comment</span>
</button>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const isOpen = !sidebar.classList.contains('-translate-x-full');
        
        if (isOpen) {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        } else {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
    
    // Close sidebar on window resize to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1024) {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });
</script>

@yield('scripts')

</body>
</html>
