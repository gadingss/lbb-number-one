<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Sistem Bimbel Privat - @yield('title', 'Admin Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .filled-icon {
            font-variation-settings: 'FILL' 1;
        }
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .font-headline { font-family: 'Manrope', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-background text-on-background antialiased">

    <!-- Mobile Overlay Backdrop -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <!-- SideNavBar -->
    <aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-blue-50 dark:bg-slate-950 flex flex-col py-8 space-y-6 z-50 transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 overflow-y-auto">
        <div class="px-6 sm:px-8 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg flex-shrink-0">
                <span class="material-symbols-outlined" data-icon="school">school</span>
            </div>
            <div class="min-w-0">
                <h1 class="text-lg font-black text-blue-900 dark:text-blue-50 leading-tight">LBB Number One Management</h1>
                <p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Bimbingan Belajar Privat</p>
            </div>
            <!-- Close button (mobile only) -->
            <button onclick="toggleSidebar()" class="lg:hidden ml-auto -mr-2 w-8 h-8 rounded-full hover:bg-blue-100 flex items-center justify-center transition-colors flex-shrink-0">
                <span class="material-symbols-outlined text-slate-500 text-lg">close</span>
            </button>
        </div>
        
        <nav class="flex-1 px-4 space-y-1">
            @php $route = Route::currentRouteName(); @endphp
            
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center gap-3 px-4 py-3 font-bold rounded-xl transition-all duration-300 ease-in-out {{ str_contains($route, 'admin.dashboard') ? 'text-blue-700 dark:text-blue-300 border-r-4 border-blue-600 dark:border-blue-400 bg-blue-100/50 dark:bg-blue-900/20' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-slate-200/50 dark:hover:bg-slate-800/50' }}">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-manrope text-sm font-medium">Dasbor</span>
            </a>
            
            <a href="{{ route('admin.tutor.index') }}" 
               class="flex items-center gap-3 px-4 py-3 font-bold rounded-xl transition-all duration-300 ease-in-out {{ str_contains($route, 'admin.tutor') ? 'text-blue-700 dark:text-blue-300 border-r-4 border-blue-600 dark:border-blue-400 bg-blue-100/50 dark:bg-blue-900/20' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-slate-200/50 dark:hover:bg-slate-800/50' }}">
                <span class="material-symbols-outlined" data-icon="school">school</span>
                <span class="font-manrope text-sm font-medium">Tutor</span>
            </a>
            
            <a href="{{ route('admin.siswa.index') }}" 
               class="flex items-center gap-3 px-4 py-3 font-bold rounded-xl transition-all duration-300 ease-in-out {{ str_contains($route, 'admin.siswa') ? 'text-blue-700 dark:text-blue-300 border-r-4 border-blue-600 dark:border-blue-400 bg-blue-100/50 dark:bg-blue-900/20' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-slate-200/50 dark:hover:bg-slate-800/50' }}">
                <span class="material-symbols-outlined" data-icon="group">group</span>
                <span class="font-manrope text-sm font-medium">Siswa</span>
            </a>
            
            <a href="{{ route('admin.mata-pelajaran.index') }}" 
               class="flex items-center gap-3 px-4 py-3 font-bold rounded-xl transition-all duration-300 ease-in-out {{ str_contains($route, 'admin.mata-pelajaran') ? 'text-blue-700 dark:text-blue-300 border-r-4 border-blue-600 dark:border-blue-400 bg-blue-100/50 dark:bg-blue-900/20' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-slate-200/50 dark:hover:bg-slate-800/50' }}">
                <span class="material-symbols-outlined" data-icon="book">book</span>
                <span class="font-manrope text-sm font-medium">Mata Pelajaran</span>
            </a>

            <a href="{{ route('admin.paket.index') }}" 
               class="flex items-center gap-3 px-4 py-3 font-bold rounded-xl transition-all duration-300 ease-in-out {{ str_contains($route, 'admin.paket') ? 'text-blue-700 dark:text-blue-300 border-r-4 border-blue-600 dark:border-blue-400 bg-blue-100/50 dark:bg-blue-900/20' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-slate-200/50 dark:hover:bg-slate-800/50' }}">
                <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                <span class="font-manrope text-sm font-medium">Paket Les</span>
            </a>
            
            <a href="{{ route('admin.jadwal.index') }}" 
               class="flex items-center gap-3 px-4 py-3 font-bold rounded-xl transition-all duration-300 ease-in-out {{ str_contains($route, 'admin.jadwal') ? 'text-blue-700 dark:text-blue-300 border-r-4 border-blue-600 dark:border-blue-400 bg-blue-100/50 dark:bg-blue-900/20' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-slate-200/50 dark:hover:bg-slate-800/50' }}">
                <span class="material-symbols-outlined" data-icon="calendar_month">calendar_month</span>
                <span class="font-manrope text-sm font-medium">Jadwal</span>
            </a>
            
            <a href="{{ route('admin.pembayaran.index') }}" 
               class="flex items-center gap-3 px-4 py-3 font-bold rounded-xl transition-all duration-300 ease-in-out {{ str_contains($route, 'admin.pembayaran') ? 'text-blue-700 dark:text-blue-300 border-r-4 border-blue-600 dark:border-blue-400 bg-blue-100/50 dark:bg-blue-900/20' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-slate-200/50 dark:hover:bg-slate-800/50' }}">
                <span class="material-symbols-outlined" data-icon="payments">payments</span>
                <span class="font-manrope text-sm font-medium">Pembayaran</span>
            </a>

            <a href="{{ route('admin.absensi.index') }}" 
               class="flex items-center gap-3 px-4 py-3 font-bold rounded-xl transition-all duration-300 ease-in-out {{ str_contains($route, 'admin.absensi') ? 'text-blue-700 dark:text-blue-300 border-r-4 border-blue-600 dark:border-blue-400 bg-blue-100/50 dark:bg-blue-900/20' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-slate-200/50 dark:hover:bg-slate-800/50' }}">
                <span class="material-symbols-outlined" data-icon="assignment_turned_in">assignment_turned_in</span>
                <span class="font-manrope text-sm font-medium">Absensi</span>
            </a>
        </nav>
        
        <div class="px-6">
            <a href="{{ route('admin.jadwal.create') }}" class="block text-center w-full py-3 bg-gradient-to-br from-primary to-primary-container text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 transition-transform duration-200">
                Tambah Sesi Baru
            </a>
        </div>
        
        <div class="px-4 pt-4 border-t border-blue-100/20">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 transition-all duration-300 ease-in-out">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-manrope text-sm font-medium">Pengaturan Profil</span>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:text-error dark:hover:text-error transition-all duration-300 ease-in-out">
                    <span class="material-symbols-outlined" data-icon="logout">logout</span>
                    <span class="font-manrope text-sm font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- TopAppBar -->
    <header class="fixed top-0 left-0 lg:left-64 right-0 h-16 bg-slate-50/80 dark:bg-slate-900/80 backdrop-blur-xl z-30 flex justify-between items-center px-4 sm:px-6 lg:px-8 shadow-sm">
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <!-- Hamburger button (mobile only) -->
            <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 rounded-full hover:bg-blue-50 flex items-center justify-center transition-colors flex-shrink-0">
                <span class="material-symbols-outlined text-slate-600">menu</span>
            </button>
            <h2 class="text-lg sm:text-xl font-bold text-on-background truncate">@yield('title', 'Dasbor')</h2>
        </div>
        <div class="flex items-center gap-3 sm:gap-6">
            <div class="flex items-center gap-4">
                <button class="relative p-2 text-slate-500 hover:bg-blue-50/50 rounded-full transition-colors active:scale-95 duration-200">
                    <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
                </button>
            </div>
            <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-blue-900 dark:text-blue-100">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">Administrator</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-lg flex-shrink-0">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Canvas -->
    <main class="lg:ml-64 pt-20 sm:pt-24 pb-12 px-4 sm:px-6 lg:px-10 min-h-screen">
        @yield('content')
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