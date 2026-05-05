<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Bimbel Privat - Tutor</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR TUTOR -->
    <aside class="w-64 bg-white shadow-xl">

        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">SISTEM BIMBEL</h2>
            <p class="text-sm text-gray-500">PRIVAT - TUTOR</p>
        </div>

        <nav class="mt-6 px-4 space-y-2">

            @php
                $route = Route::currentRouteName();
            @endphp

            <a href="{{ route('tutor.dashboard') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ str_contains($route, 'tutor.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                Dashboard
            </a>

            <a href="{{ route('tutor.jadwal.index') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ str_contains($route, 'tutor.jadwal') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                Jadwal Mengajar
            </a>

            <a href="{{ route('tutor.absensi.index') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ str_contains($route, 'tutor.absensi') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                Catat Absensi
            </a>

            <a href="{{ route('tutor.riwayat.index') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ str_contains($route, 'tutor.riwayat') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                Riwayat Mengajar
            </a>

            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 rounded-lg transition
               {{ str_contains($route, 'profile') ? 'bg-blue-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                Profil Saya
            </a>

        </nav>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col">

        <!-- TOPBAR -->
        <header class="bg-white shadow px-8 py-4 flex justify-between items-center">

            <h1 class="text-xl font-semibold text-gray-700">
                @yield('title', 'Dashboard Tutor')
            </h1>

            <div class="flex items-center gap-4">

                <!-- Dropdown Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-gray-600 hover:text-gray-800 font-medium">
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Content -->
                    <div x-show="open" @click.away="open = false" 
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-2 z-50"
                         style="display: none;">
                        
                        <!-- Profile Link -->
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil
                        </a>

                        <!-- Separator -->
                        <hr class="my-1">

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-red-600 hover:bg-red-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>

</div>

@yield('scripts')

</body>
</html>
