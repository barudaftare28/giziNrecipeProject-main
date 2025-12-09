{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.customer')

@section('title', 'Daftar | NutriRecipe')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Biar form agak ke tengah --}}
        <div class="min-h-[60vh] flex items-center">
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                {{-- Side copy / branding --}}
                <div class="space-y-3">
                    <p class="text-xs font-semibold tracking-[0.25em] uppercase text-emerald-600">
                        NutriRecipe
                    </p>
                    <h1
                        class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-neutral-100 md:text-neutral-900">
                        Buat akun baru
                    </h1>
                    <p class="text-sm text-neutral-300 md:text-neutral-500">
                        Dengan akun NutriRecipe kamu bisa menyimpan resep favorit, menulis komentar, memberikan rating,
                        dan membagikan resep sehat andalanmu ke komunitas.
                    </p>
                </div>

                {{-- Card register --}}
                <div class="bg-white border border-neutral-100 rounded-sm p-6 sm:p-8 space-y-6">
                    <div class="space-y-1">
                        <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                            Daftar
                        </h2>
                        <p class="text-sm text-neutral-500">
                            Isi data berikut untuk membuat akun baru.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <label for="name"
                                class="block text-xs font-semibold tracking-wide uppercase text-neutral-700">
                                Nama lengkap
                            </label>
                            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                                autocomplete="name"
                                class="mt-1 block w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs" />
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="email"
                                class="block text-xs font-semibold tracking-wide uppercase text-neutral-700">
                                Email
                            </label>
                            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                                autocomplete="username"
                                class="mt-1 block w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs" />
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password"
                                class="block text-xs font-semibold tracking-wide uppercase text-neutral-700">
                                Password
                            </label>
                            <x-text-input id="password" type="password" name="password" required
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs" />
                            <p class="mt-1 text-[11px] text-neutral-400">
                                Minimal 8 karakter. Gunakan kombinasi huruf dan angka agar lebih aman.
                            </p>
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label for="password_confirmation"
                                class="block text-xs font-semibold tracking-wide uppercase text-neutral-700">
                                Konfirmasi Password
                            </label>
                            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                                autocomplete="new-password"
                                class="mt-1 block w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs" />
                        </div>

                        {{-- Tombol daftar --}}
                        <div class="pt-2">
                            <button type="submit"
                                class="inline-flex w-full items-center justify-center rounded-sm bg-emerald-600 px-4 py-2.5
                                           text-sm font-semibold text-white hover:bg-emerald-700
                                           focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                                Daftar
                            </button>
                        </div>
                    </form>

                    {{-- Link ke login --}}
                    <p class="text-xs sm:text-sm text-neutral-600 text-center pt-2">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-700">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
