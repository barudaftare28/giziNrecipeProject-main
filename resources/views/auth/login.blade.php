{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.customer')

@section('title', 'Login | NutriRecipe')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Biar konten login agak ke tengah secara vertikal --}}
        <div class="min-h-[60vh] flex items-center">
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                {{-- Side copy / branding --}}
                <div class="space-y-3">
                    <p class="text-xs font-semibold tracking-[0.25em] uppercase text-emerald-600">
                        NutriRecipe
                    </p>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-neutral-100 md:text-neutral-900">
                        Masuk ke akunmu
                    </h1>
                    <p class="text-sm text-neutral-300 md:text-neutral-500">
                        Simpan resep favoritmu, beri rating, tulis komentar, dan bandingkan nilai gizi antar resep.
                        Masuk untuk melanjutkan perjalanan masak sehatmu.
                    </p>
                </div>

                {{-- Card login --}}
                <div class="bg-white border border-neutral-100 rounded-sm p-6 sm:p-8 space-y-6">
                    {{-- Status sesi (misalnya setelah reset password) --}}
                    <x-auth-session-status class="mb-2 text-sm" :status="session('status')" />

                    <div class="space-y-1">
                        <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                            Login
                        </h2>
                        <p class="text-sm text-neutral-500">
                            Masukkan email dan kata sandi yang terdaftar.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email"
                                   class="block text-xs font-semibold tracking-wide uppercase text-neutral-700">
                                Email
                            </label>
                            <x-text-input
                                id="email"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required
                                autofocus
                                autocomplete="username"
                                class="mt-1 block w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password"
                                   class="block text-xs font-semibold tracking-wide uppercase text-neutral-700">
                                Password
                            </label>
                            <x-text-input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="mt-1 block w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                        </div>

                        {{-- Remember + Forgot password --}}
                        <div class="flex items-center justify-between gap-4 pt-1">
                            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="h-4 w-4 rounded border-neutral-300 text-emerald-600
                                           focus:ring-emerald-500"
                                >
                                <span class="text-xs sm:text-sm text-neutral-600">
                                    Remember me
                                </span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="text-xs sm:text-sm font-medium text-neutral-500 hover:text-neutral-800">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        {{-- Tombol login --}}
                        <div class="pt-2">
                            <button type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-sm bg-neutral-900 px-4 py-2.5
                                           text-sm font-semibold text-white hover:bg-neutral-800
                                           focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                                Masuk
                            </button>
                        </div>
                    </form>

                    {{-- Link ke register --}}
                    @if (Route::has('register'))
                        <p class="text-xs sm:text-sm text-neutral-600 text-center pt-2">
                            Belum punya akun?
                            <a href="{{ route('register') }}"
                               class="font-semibold text-emerald-600 hover:text-emerald-700">
                                Daftar sekarang
                            </a>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
