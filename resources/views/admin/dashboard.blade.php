{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin | NutriRecipe')
@section('page_title', 'Dashboard Admin')

@section('content')
    <div class="space-y-6">

        {{-- Heading + deskripsi singkat --}}
        <section>
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900">
                Ringkasan Sistem
            </h1>
            <p class="mt-1 text-sm text-neutral-500">
                Pantau statistik resep dan lakukan aksi cepat dari satu tempat.
            </p>
        </section>

        {{-- Kartu statistik --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border border-neutral-100 rounded-sm p-4 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium uppercase tracking-wide text-neutral-500">
                        Total Resep
                    </span>
                </div>
                <div class="text-3xl font-semibold text-neutral-900">
                    {{ $recipeCount ?? '-' }}
                </div>
                <p class="text-xs text-neutral-400">
                    Jumlah seluruh resep yang tersimpan di sistem.
                </p>
            </div>

            {{-- Nanti bisa ditambah kartu lain: total user, total komentar, dsb --}}
        </section>

        {{-- Aksi cepat --}}
        <section class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white border border-neutral-100 rounded-sm p-4">
                <h2 class="text-sm font-semibold text-neutral-900 mb-3">
                    Aksi Cepat
                </h2>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('admin.recipes.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-sm text-sm font-medium
                              bg-emerald-600 text-white hover:bg-emerald-700 transition">
                        <span class="material-symbols-outlined text-base">Tambah Resep Official</span>
                    </a>

                    <a href="{{ route('admin.recipes.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-sm text-sm font-medium
                              bg-neutral-900 text-white hover:bg-neutral-800 transition">
                        <span class="material-symbols-outlined text-base">Kelola Semua Resep</span>
                    </a>
                </div>
            </div>
        </section>

    </div>
@endsection
