<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Dashboard Tutor') - LBB Number One</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-primary": "#ffffff",
                        "surface": "#f8f9ff",
                        "on-secondary-fixed-variant": "#31447b",
                        "on-secondary-container": "#394c84",
                        "on-surface-variant": "#434655",
                        "on-tertiary-fixed": "#360f00",
                        "on-tertiary-container": "#ffede6",
                        "error": "#ba1a1a",
                        "inverse-primary": "#b4c5ff",
                        "surface-container-lowest": "#ffffff",
                        "secondary-fixed-dim": "#b4c5ff",
                        "on-secondary": "#ffffff",
                        "error-container": "#ffdad6",
                        "primary": "#004ac6",
                        "surface-container-high": "#dce9ff",
                        "surface-bright": "#f8f9ff",
                        "surface-dim": "#ccdbf3",
                        "secondary": "#495c95",
                        "surface-tint": "#0053db",
                        "on-tertiary": "#ffffff",
                        "inverse-surface": "#233144",
                        "background": "#f8f9ff",
                        "on-background": "#0d1c2e",
                        "on-secondary-fixed": "#00174b",
                        "tertiary-container": "#bc4800",
                        "surface-variant": "#d5e3fc",
                        "primary-fixed": "#dbe1ff",
                        "on-surface": "#0d1c2e",
                        "on-primary-container": "#eeefff",
                        "on-tertiary-fixed-variant": "#7d2d00",
                        "on-primary-fixed": "#00174b",
                        "on-error": "#ffffff",
                        "tertiary-fixed-dim": "#ffb596",
                        "surface-container-low": "#eff4ff",
                        "secondary-fixed": "#dbe1ff",
                        "inverse-on-surface": "#eaf1ff",
                        "on-primary-fixed-variant": "#003ea8",
                        "surface-container-highest": "#d5e3fc",
                        "on-error-container": "#93000a",
                        "outline-variant": "#c3c6d7",
                        "surface-container": "#e6eeff",
                        "primary-container": "#2563eb",
                        "tertiary": "#943700",
                        "secondary-container": "#acbfff",
                        "outline": "#737686",
                        "tertiary-fixed": "#ffdbcd",
                        "primary-fixed-dim": "#b4c5ff"
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
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .gradient-primary { background: linear-gradient(135deg, #004ac6 0%, #2563eb 100%); }
        .glass-header { background: rgba(248, 249, 255, 0.8); backdrop-filter: blur(24px); }
        .ambient-shadow { box-shadow: 0 12px 32px -4px rgba(13, 28, 46, 0.06); }
        body { font-family: 'Inter', sans-serif; }
        .font-headline { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-surface font-body text-on-surface antialiased">

<!-- Mobile Overlay Backdrop -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- SideNavBar -->
<aside id="sidebar" class="bg-surface-container-low dark:bg-inverse-surface h-screen w-72 fixed left-0 top-0 flex flex-col py-8 px-4 z-50 overflow-y-auto transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0">
    <div class="mb-12 px-2 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center text-on-primary shadow-lg flex-shrink-0">
            <span class="material-symbols-outlined" data-icon="school" style="font-variation-settings: 'FILL' 1;">school</span>
        </div>
        <div class="min-w-0">
            <h1 class="font-headline font-black text-lg text-primary dark:text-primary-fixed-variant leading-tight">LBB Number One Management</h1>
            <p class="text-[10px] text-on-surface-variant/80 font-bold uppercase tracking-widest">Bimbingan Belajar Privat</p>
        </div>
        <!-- Close button (mobile only) -->
        <button onclick="toggleSidebar()" class="lg:hidden ml-auto -mr-2 w-8 h-8 rounded-full hover:bg-surface-container-high flex items-center justify-center transition-colors flex-shrink-0">
            <span class="material-symbols-outlined text-on-surface-variant text-lg">close</span>
        </button>
    </div>
    
    <nav class="flex-grow space-y-1">
        @php $route = Route::currentRouteName(); @endphp
        
        <a class="{{ str_contains($route, 'tutor.dashboard') ? 'bg-surface-container-highest dark:bg-surface-variant text-primary dark:text-on-primary-container font-bold rounded-r-full mr-4 shadow-sm' : 'text-on-surface-variant dark:text-outline-variant hover:text-primary hover:bg-surface-container-high rounded-r-full mr-4 transition-all' }} flex items-center gap-4 px-4 py-3" href="{{ route('tutor.dashboard') }}">
            <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
            <span class="font-label">Dashboard</span>
        </a>
        
        <a class="{{ str_contains($route, 'tutor.jadwal') ? 'bg-surface-container-highest dark:bg-surface-variant text-primary dark:text-on-primary-container font-bold rounded-r-full mr-4 shadow-sm' : 'text-on-surface-variant dark:text-outline-variant hover:text-primary hover:bg-surface-container-high rounded-r-full mr-4 transition-all' }} flex items-center gap-4 px-4 py-3" href="{{ route('tutor.jadwal.index') }}">
            <span class="material-symbols-outlined" data-icon="calendar_today">calendar_today</span>
            <span class="font-label">Jadwal Mengajar</span>
        </a>
        
        <a class="{{ str_contains($route, 'tutor.absensi') ? 'bg-surface-container-highest dark:bg-surface-variant text-primary dark:text-on-primary-container font-bold rounded-r-full mr-4 shadow-sm' : 'text-on-surface-variant dark:text-outline-variant hover:text-primary hover:bg-surface-container-high rounded-r-full mr-4 transition-all' }} flex items-center gap-4 px-4 py-3" href="{{ route('tutor.absensi.index') }}">
            <span class="material-symbols-outlined" data-icon="assignment_turned_in">assignment_turned_in</span>
            <span class="font-label">Catat Absensi</span>
        </a>
        
        <a class="{{ str_contains($route, 'tutor.riwayat') ? 'bg-surface-container-highest dark:bg-surface-variant text-primary dark:text-on-primary-container font-bold rounded-r-full mr-4 shadow-sm' : 'text-on-surface-variant dark:text-outline-variant hover:text-primary hover:bg-surface-container-high rounded-r-full mr-4 transition-all' }} flex items-center gap-4 px-4 py-3" href="{{ route('tutor.riwayat.index') }}">
            <span class="material-symbols-outlined" data-icon="history">history</span>
            <span class="font-label">Riwayat Mengajar</span>
        </a>
    </nav>
    
    <div class="mt-auto border-t border-outline-variant/10 pt-6 space-y-1">
        <a class="{{ str_contains($route, 'profile') ? 'bg-surface-container-highest dark:bg-surface-variant text-primary dark:text-on-primary-container font-bold rounded-r-full mr-4 shadow-sm' : 'text-on-surface-variant dark:text-outline-variant hover:text-primary hover:bg-surface-container-high rounded-r-full mr-4 transition-all' }} flex items-center gap-4 px-4 py-3" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined" data-icon="settings">settings</span>
            <span class="font-label">Profil Saya</span>
        </a>
        
        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
            @csrf
            <button type="submit" class="w-full text-left text-on-surface-variant dark:text-outline-variant hover:text-error dark:hover:text-error hover:bg-error-container/20 rounded-r-full mr-4 transition-all flex items-center gap-4 px-4 py-3">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                <span class="font-label">Logout</span>
            </button>
        </form>
    </div>
</aside>

<!-- Main Canvas -->
<main class="lg:ml-72 min-h-screen">
    <!-- TopAppBar -->
    <header class="fixed top-0 right-0 left-0 lg:left-72 h-20 glass-header flex justify-between items-center px-4 sm:px-6 lg:px-12 z-30">
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <!-- Hamburger button (mobile only) -->
            <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 rounded-full hover:bg-surface-container-high flex items-center justify-center transition-colors flex-shrink-0">
                <span class="material-symbols-outlined text-on-surface-variant">menu</span>
            </button>
            <h2 class="text-lg sm:text-xl font-bold text-on-surface truncate">@yield('title', 'Dashboard')</h2>
        </div>
        <div class="flex items-center gap-3 sm:gap-6 ml-4">
            <button class="relative text-on-surface-variant hover:text-primary transition-colors">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                <span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full ring-2 ring-surface"></span>
            </button>
            <div class="flex items-center gap-3 pl-3 sm:pl-6 border-l border-outline-variant/20">
                <div class="text-right hidden sm:block">
                    <p class="font-semibold text-sm leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest mt-1">Tutor</p>
                </div>
                <div class="w-10 h-10 rounded-full border-2 border-primary-fixed bg-primary text-white flex items-center justify-center font-bold text-lg shadow-sm flex-shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <!-- Page Content -->
    <div class="pt-24 sm:pt-28 pb-12 px-4 sm:px-6 lg:px-12">
        @yield('content')
    </div>
</main>

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
