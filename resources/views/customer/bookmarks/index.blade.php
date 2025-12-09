{{-- resources/views/customer/bookmarks/index.blade.php --}}
@extends('layouts.customer')

@section('title', 'Resep Favorit | NutriRecipe')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-neutral-900">
                Resep Favorit Saya
            </h1>
            <p class="mt-1 text-sm text-neutral-400">
                Lihat kembali resep-resep yang sudah kamu simpan sebagai favorit.
            </p>
        </div>

        {{-- Search + Filter --}}
        <div class="bg-white border border-neutral-100 rounded-sm p-4">
            <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
                <form action="{{ route('bookmarks.index') }}" method="GET" class="flex-1 flex gap-2">
                    @if (request('type'))
                        <input type="hidden" name="type" value="{{ request('type') }}">
                    @endif

                    <input type="text" name="search" value="{{ request('search') }}"
                        class="w-full rounded-sm border border-neutral-200 px-4 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Cari resep favorit berdasarkan nama, durasi, atau pembuat...">
                    <button type="submit"
                        class="inline-flex items-center rounded-sm bg-neutral-900 px-4 py-1.5 text-sm font-medium text-white hover:bg-neutral-800">
                        Cari
                    </button>
                </form>
            </div>

            {{-- Filter Resep --}}
            <div class="flex items-center gap-3 mt-4">
                <a href="{{ route('bookmarks.index') }}"
                    class="px-4 py-1.5 rounded-sm text-sm font-medium 
                    {{ request('type') ? 'bg-neutral-100 text-neutral-400' : 'bg-emerald-600 text-white' }}">
                    Semua
                </a>
                <a href="{{ route('bookmarks.index', ['type' => 'komunitas'] + request()->only('search')) }}"
                    class="px-4 py-1.5 rounded-sm text-sm font-medium 
                    {{ request('type') == 'komunitas' ? 'bg-emerald-600 text-white' : 'bg-neutral-100 text-neutral-400' }}">
                    Resep Komunitas
                </a>
                <a href="{{ route('bookmarks.index', ['type' => 'official'] + request()->only('search')) }}"
                    class="px-4 py-1.5 rounded-sm text-sm font-medium 
                    {{ request('type') == 'official' ? 'bg-emerald-600 text-white' : 'bg-neutral-100 text-neutral-400' }}">
                    Resep Official
                </a>
            </div>
        </div>

        {{-- Grid resep favorit --}}
        @if ($recipes->isEmpty())
            <div class="bg-white border border-neutral-100 rounded-sm p-6 text-sm text-neutral-600">
                <p class="font-medium">Belum ada resep yang kamu simpan.</p>
                <p class="mt-1 text-neutral-500">
                    Buka salah satu resep lalu tekan ikon hati untuk menyimpannya sebagai favorit.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($recipes as $recipe)
                    <a href="{{ route('customer.recipes.show', $recipe->id) }}"
                        class="group bg-white border border-neutral-100 rounded-sm overflow-hidden flex flex-col">
                        {{-- Foto --}}
                        <img src="{{ $recipe->photo ? $recipe->photo_url : 'https://placehold.co/600x400/e2e8f0/e2e8f0?text=NutriRecipe' }}"
                            alt="{{ $recipe->name }}"
                            class="h-40 w-full object-cover group-hover:brightness-95 transition">

                        <div class="flex-1 p-4 flex flex-col gap-2">
                            {{-- Badge official / user + durasi --}}
                            <div class="flex items-center justify-between gap-2">
                                @if ($recipe->is_official)
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold uppercase tracking-wide text-emerald-700">
                                        Resep Official
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center rounded-full bg-neutral-100 px-2 py-0.5 text-[11px] font-semibold uppercase text-neutral-400">
                                        Resep Komunitas
                                    </span>
                                @endif

                                <span class="inline-flex items-center gap-1 text-[11px] text-neutral-500">
                                    {{ $recipe->duration }}
                                </span>
                            </div>

                            {{-- Judul --}}
                            <h3 class="mt-1 text-sm font-semibold text-neutral-900 line-clamp-2">
                                {{ $recipe->name }}
                            </h3>

                            {{-- Pembuat --}}
                            <p class="text-xs text-neutral-500">
                                Oleh:
                                @if ($recipe->is_official)
                                    <span class="font-medium text-neutral-700">
                                        Pakar Gizi ({{ $recipe->nutritionist }})
                                    </span>
                                @else
                                    <span class="font-medium text-neutral-700">
                                        {{ $recipe->user->name ?? 'User' }}
                                    </span>
                                @endif
                            </p>

                            {{-- Keterangan singkat --}}
                            @if ($recipe->description)
                                <p class="text-xs text-neutral-500 line-clamp-2 mt-1">
                                    {{ \Illuminate\Support\Str::limit($recipe->description, 90) }}
                                </p>
                            @endif

                            {{-- Rating & Komentar --}}
                            <div class="mt-2 flex items-center justify-between text-[11px] text-neutral-500">
                                <div class="flex items-center gap-1">
                                    {{-- ikon bintang --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-3.5 h-3.5 text-amber-400">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.175 0l-2.802 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>

                                    @if ($recipe->ratings_avg_rating)
                                        <span class="font-medium">
                                            {{ number_format($recipe->ratings_avg_rating, 1) }}
                                        </span>
                                        <span>/ 5</span>
                                    @else
                                        <span class="italic">Belum ada rating</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-1">
                                    <span>{{ $recipe->comments_count ?? 0 }} komentar</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Paginasi --}}
            <div class="mt-6">
                {{ $recipes->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
