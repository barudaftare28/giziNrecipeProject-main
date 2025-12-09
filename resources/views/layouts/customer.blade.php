<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'NutriRecipe')</title>

    <!-- Google Font: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        referrerpolicy="no-referrer">


</head>

<body class="font-sans antialiased bg-neutral-100 text-neutral-900">
    <div class="min-h-screen flex flex-col">

        <header class="bg-black text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

                <!-- Brand -->
                <div class="flex items-center">
        
        {{-- 1. Tampilkan Logo --}}
        {{-- Pastikan file ada di public/images/nutrirecipe_logo.png --}}
        <img src="{{ asset('img/NutriRecipe_logo.png') }}" 
             alt="NutriRecipe Logo" 
             class="h-12 w-auto object-contain">
                    {{-- <div>
                        <p class="text-3xl font-black text-emerald-500">NutriRecipe</p>
                        <p class="text-xs text-neutral-300">Makan sehat, hidup lebih baik</p>
                    </div>
                </div> --}}

                <!-- Nav links (desktop) -->
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="{{ route('customer.dashboard') }}"
                        class="{{ request()->routeIs('customer.dashboard') ? 'text-emerald-400' : 'text-white hover:text-neutral-200' }}">
                        Beranda
                    </a>

                    <a href="{{ route('customer.recipes.index') }}"
                        class="{{ request()->routeIs('customer.recipes.*') ? 'text-emerald-400' : 'text-white hover:text-neutral-200' }}">
                        Semua Resep
                    </a>

                    @auth
                        <a href="{{ route('bookmarks.index') }}"
                            class="{{ request()->routeIs('bookmarks.*') ? 'text-emerald-400' : 'text-white hover:text-neutral-200' }}">
                            Resep Favorit
                        </a>

                        <a href="{{ route('customer.recipes.create-rules') }}"
                            class="{{ request()->routeIs('customer.recipes.create-rules') ? 'text-emerald-400' : 'text-white hover:text-neutral-200' }}">
                            Buat Resep
                        </a>

                        <a href="{{ route('customer.recipes.compare') }}"
                            class="{{ request()->routeIs('customer.recipes.compare') ? 'text-emerald-400' : 'text-white hover:text-neutral-200' }}">
                            Bandingkan Resep
                        </a>
                    @endauth


                    <a href="{{ route('about') }}"
                        class="{{ request()->routeIs('about') ? 'text-emerald-400' : 'text-white hover:text-neutral-200' }}">
                        Tentang Kami
                    </a>
                </nav>

                <!-- Right side -->
                <div class="flex items-center gap-4">
                    @auth
                        {{-- Jika sudah login: tampil nama + tombol keluar --}}
                        <div class="hidden sm:flex flex-col items-end leading-tight">
                            <span class="text-sm text-white">{{ auth()->user()->name }}</span>
                            <span class="text-xs text-neutral-400">Pengguna NutriRecipe</span>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center rounded-full border border-neutral-500 px-3 py-1.5 text-xs font-medium text-neutral-200 hover:border-red-500 hover:text-red-500 transition ease-in-out">
                                Keluar
                            </button>
                        </form>
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}"
                                class="text-xs sm:text-sm text-white hover:text-neutral-200">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center rounded-full border border-emerald-600 px-3 py-1.5 text-xs font-semibold text-emerald-400 hover:bg-emerald-600/20 hover:text-emerald-400 transition">
                                    Daftar
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>

            </div>
        </header>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 py-12">
            @yield('content')
        </main>

        <!-- FOOTER -->
        <footer class="bg-black text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <p class="text-[11px] text-neutral-400">
                    &copy; {{ date('Y') }} NutriRecipe. Dibuat untuk mendukung hidup sehat.
                </p>
                <p class="hidden sm:block text-[11px] text-neutral-400">
                    Fokus pada resep bergizi, bukan sekadar rasa.
                </p>
            </div>
        </footer>
    </div>
</body>

</html>
