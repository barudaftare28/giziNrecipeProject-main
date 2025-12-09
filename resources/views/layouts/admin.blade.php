<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin | NutriRecipe')</title>

    <!-- Google Font: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!-- Fonts & Styles (standar Laravel + Tailwind) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-neutral-50 text-neutral-900">
    <div class="min-h-screen flex">

        {{-- Sidebar kiri (admin only) --}}
        <aside class="hidden md:flex md:flex-col w-64 bg-white border-r border-neutral-200">
            <div class="h-16 flex items-center px-6 border-b border-neutral-200">
               <div class="flex items-center gap-3">
                    {{-- <span
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-emerald-600 text-white font-semibold">
                        N
                    </span> --}}
                    {{-- logo --}}
                    <img src="{{ asset('img/NutriRecipe_logo.png') }}" 
                        alt="NutriRecipe Logo" 
                        class="h-12 w-auto object-contain">
                        {{-- <div>
                            <p class="text-sm font-semibold tracking-tight">NutriRecipe</p>
                            <p class="text-xs text-neutral-500">Admin Panel</p>
                        </div> --}}
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-sm text-sm font-medium
                              {{ request()->routeIs('admin.dashboard')
                                  ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-500'
                                  : 'text-neutral-600 hover:bg-neutral-50' }}">
                    <span class="material-symbols-outlined text-base">Dashboard</span>
                </a>

                {{-- Kelola Resep --}}
                <a href="{{ route('admin.recipes.index') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-sm text-sm font-medium
                              {{ request()->routeIs('admin.recipes.*')
                                  ? 'bg-emerald-50 text-emerald-700 border-l-4 border-emerald-500'
                                  : 'text-neutral-600 hover:bg-neutral-50' }}">
                    <span class="material-symbols-outlined text-base">Kelola Resep</span>
                </a>

                {{-- Nanti bisa ditambah menu lain: komentar, user, dll --}}
            </nav>

            <div class="border-t border-neutral-200 px-4 py-3 text-xs text-neutral-500 space-y-3">
                @auth
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2">
                            <div
                                class="h-8 w-8 rounded-full bg-neutral-100 flex items-center justify-center text-[11px] font-semibold text-neutral-700">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-[11px] font-medium text-neutral-700 truncate max-w-[120px]">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-[11px] text-neutral-400">
                                    Akun admin
                                </p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-1 rounded-full border border-neutral-200 px-2.5 py-1 text-[11px] font-medium text-neutral-600 hover:bg-neutral-50">
                                <span class="material-symbols-outlined">Keluar</span>
                            </button>
                        </form>
                    </div>
                @endauth

                <p class="text-[11px] text-neutral-400">
                    &copy; {{ date('Y') }} NutriRecipe
                </p>
            </div>

        </aside>

        {{-- Area konten kanan --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- App bar atas --}}
            <header
                class="h-16 bg-white border-b border-neutral-200 flex items-center justify-between px-4 md:px-6">
                <div class="flex items-center gap-3">
                    <button
                        class="md:hidden inline-flex items-center justify-center rounded-sm border border-neutral-200 p-2 text-neutral-600">
                        {{-- Untuk sekarang tombol ini hanya visual (tanpa JS) --}}
                        <span class="material-symbols-outlined text-base">menu</span>
                    </button>
                    <div>
                        <p class="text-sm font-semibold leading-tight">@yield('page_title', 'Dashboard Admin')</p>
                        <p class="text-xs text-neutral-500">Panel pengelolaan resep dan konten nutrisi.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <div class="hidden sm:flex flex-col items-end">
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                            <span class="text-xs text-neutral-500">Admin</span>
                        </div>
                    @endauth
                </div>
            </header>

            {{-- Main content --}}
            <main class="flex-1 overflow-y-auto px-4 py-6 md:px-6 md:py-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
