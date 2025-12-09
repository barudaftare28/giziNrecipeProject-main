{{-- resources/views/customer/recipes/show.blade.php --}}
@extends('layouts.customer')

@section('title', $recipe->name . ' | NutriRecipe')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- Tombol kembali --}}
        <div>
            <a href="{{ route('customer.recipes.index') }}"
                class="inline-flex items-center text-sm font-medium text-neutral-400 hover:text-neutral-600 gap-2 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke daftar resep
            </a>
        </div>

        {{-- Notifikasi sukses
        @if (session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm rounded-sm px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-sm rounded-sm px-4 py-3">
                {{ session('error') }}
            </div>
        @endif --}}


        {{-- Header + actions --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="space-y-2">
                <h1 class="text-4xl sm:text-4xl font-black tracking-widest uppercase text-neutral-900">
                    {{ $recipe->name }}
                </h1>

                @if ($recipe->ratings_count > 0)
                    @php
                        $rounded = (int) round($averageRating);
                    @endphp
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-0.5">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-4 h-4 {{ $i <= $rounded ? 'text-amber-400' : 'text-neutral-300' }}">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.175 0l-2.802 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm font-medium text-neutral-800">
                            {{ number_format($averageRating, 1) }} / 5
                        </span>
                        <span class="text-sm text-neutral-400">
                            ({{ $recipe->ratings_count }} rating)
                        </span>
                    </div>
                @else
                    <p class="text-sm text-neutral-600">
                        Belum ada rating untuk resep ini. Jadilah yang pertama memberi rating.
                    </p>
                @endif

            </div>

            {{-- Actions (bookmark + edit/hapus) --}}
            <div class="flex items-center gap-2">
                @auth
                    {{-- Bookmark --}}
                    <form action="{{ route('recipes.bookmark', $recipe->id) }}" method="POST" class="inline-block">
                        @csrf
                        <button type="submit"
                            title="{{ $recipe->isBookmarkedBy(auth()->user()) ? 'Hapus dari Simpanan' : 'Simpan Resep' }}"
                            class="p-2 rounded-full transition-colors focus:outline-none
                                    {{ $recipe->isBookmarkedBy(auth()->user())
                                        ? 'bg-rose-500 text-white hover:bg-rose-600'
                                        : 'bg-white text-neutral-600 hover:text-rose-600 transition-colors' }}">
                            @if ($recipe->isBookmarkedBy(auth()->user()))
                                {{-- icon love filled --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"
                                        clip-rule="evenodd" />
                                </svg>
                            @else
                                {{-- icon love outline --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            @endif
                        </button>
                    </form>
                    <a href="{{ route('customer.recipes.compare', ['recipe1' => $recipe->id]) }}"
                        class="inline-flex items-center rounded-sm border border-neutral-300 bg-white px-3 py-1.5 text-xs sm:text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                        Bandingkan dengan resep lain
                    </a>
                @endauth
            </div>
        </div>

        {{-- Konten utama resep --}}
        <div class="bg-white border border-neutral-100 rounded-sm overflow-hidden">
            {{-- Foto --}}
            <div class="relative">
                <img src="{{ $recipe->photo ? $recipe->photo_url : 'https://placehold.co/800x400/e2e8f0/e2e8f0?text=NutriRecipe' }}"
                    alt="{{ $recipe->name }}" class="w-full h-72 object-cover">

                <!-- Gradient overlay bagian bawah -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

                {{-- Badge Resep Official --}}
                @if ($recipe->is_official)
                    <span
                        class="absolute bottom-3 left-3 inline-flex items-center rounded-full bg-emerald-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-wide text-emerald-700 shadow-lg">
                        Resep Official
                    </span>
                @endif

                {{-- EDIT / DELETE BUTTONS (hanya pemilik resep) --}}
                @if (Auth::id() == $recipe->user_id)
                    <div class="absolute bottom-3 right-3 flex items-center gap-2">

                        {{-- Edit --}}
                        <a href="{{ route('customer.recipes.edit', $recipe->id) }}"
                            class="inline-flex items-center rounded-sm bg-amber-200 text-amber-600 px-3 py-1.5 text-xs font-medium shadow-md hover:bg-amber-300 transition">
                            Edit
                        </a>

                        {{-- Hapus --}}
                        <form action="{{ route('customer.recipes.destroy', $recipe->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center rounded-sm bg-red-200 text-red-600 px-3 py-1.5 text-xs font-medium shadow-md hover:bg-red-300 transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endif
            </div>


            <div class="p-6 md:p-8 space-y-6">
                {{-- Deskripsi --}}
                <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900 mb-1">Deskripsi</h2>
                        <p class="text-sm text-neutral-700">
                            {{ $recipe->description }}
                        </p>
                    </div>
                    <div>
                        <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900 mb-1">Oleh</h2>
                        <p class="text-sm text-neutral-700">
                            @if ($recipe->is_official)
                                <span class="">Pakar Gizi
                                    ({{ $recipe->nutritionist }})</span>
                            @else
                                <span class="">{{ $recipe->user->name ?? 'User' }}</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900 mb-1">Durasi</h2>
                        <p class="text-sm text-neutral-700">
                            {{ $recipe->duration }}
                        </p>
                    </div>
                </section>

                <hr class="border-neutral-200">

                {{-- Bahan + Gizi --}}
                <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900 mb-2">Alat & Bahan</h2>
                        <ul class="list-disc list-inside space-y-1 text-sm text-neutral-700">
                            @foreach ($recipe->ingredients as $ingredient)
                                <li>{{ $ingredient->item }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900 mb-2">Informasi Gizi</h2>
                        <ul class="space-y-1 text-sm text-neutral-700">
                            @forelse($recipe->nutritions as $nutrition)
                                <li class="flex items-center justify-between gap-2">
                                    <span>{{ $nutrition->name }}</span>
                                    <span class="font-medium">{{ $nutrition->value }}</span>
                                </li>
                            @empty
                                <li class="text-neutral-500 text-sm">Informasi gizi tidak tersedia.</li>
                            @endforelse
                        </ul>
                    </div>
                </section>

                {{-- Langkah --}}
                <section>
                    <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900 mb-2">Langkah Pembuatan</h2>
                    <ol class="list-decimal list-inside space-y-2 text-sm text-neutral-700">
                        @foreach ($recipe->steps as $step)
                            <li>{{ $step->instruction }}</li>
                        @endforeach
                    </ol>
                </section>
            </div>
        </div>

        {{-- Rating & Komentar --}}
        <div class="space-y-6 mt-4">

            <section class="bg-white border border-neutral-100 rounded-sm p-6 space-y-4">
                {{-- Header ringkasan rating --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-md font-bold tracking-wider uppercase text-neutral-900 mb-2">
                            Rating Resep
                        </p>

                        @if ($recipe->ratings_count > 0)
                            @php
                                $rounded = (int) round($averageRating);
                            @endphp
                            <div class="mt-1 flex items-center gap-2">
                                <div class="flex items-center gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-4 h-4 {{ $i <= $rounded ? 'text-amber-400' : 'text-neutral-300' }}">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.175 0l-2.802 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm font-medium text-neutral-800">
                                    {{ number_format($averageRating, 1) }} / 5
                                </span>
                                <span class="text-xs text-neutral-500">
                                    ({{ $recipe->ratings_count }} rating)
                                </span>
                            </div>
                        @else
                            <p class="mt-1 text-sm text-neutral-600">
                                Belum ada rating untuk resep ini.
                            </p>
                        @endif
                    </div>

                    {{-- Pesan konteks di sisi kanan --}}
                    <div class="text-sm text-neutral-600 md:text-right">
                        @auth
                            @if (Auth::id() === $recipe->user_id)
                                <p>
                                    Ini adalah resep milikmu sendiri, sehingga kamu tidak dapat memberi rating.
                                </p>
                            @elseif($userRating)
                                <p>
                                    Kamu sudah memberi rating:
                                    <span class="font-semibold text-neutral-900">{{ $userRating->rating }} / 5</span>
                                </p>
                            @elseif ($recipe->ratings_count > 0)
                                <p>
                                    Bantu pengguna lain dengan menambahkan ratingmu.
                                </p>
                            @else
                                <p>
                                    Jadilah orang pertama yang memberi rating untuk resep ini.
                                </p>
                            @endif
                        @else
                            <p>
                                Silakan <span class="font-medium">login</span> untuk memberi rating.
                            </p>
                        @endauth
                    </div>
                </div>

                {{-- Form rating: hanya muncul kalau user boleh dan belum pernah rating --}}
                @auth
                    @if (Auth::id() !== $recipe->user_id && !$userRating)
                        <form action="{{ route('ratings.store', $recipe->id) }}" method="POST"
                            class="pt-4 border-t border-neutral-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            @csrf

                            <p class="text-sm font-medium text-neutral-800">
                                Pilih ratingmu:
                            </p>

                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="rating" value="{{ $i }}"
                                                class="sr-only peer" required>
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full border text-sm font-medium
                                                       border-neutral-300 text-neutral-700 hover:bg-amber-50
                                                       peer-checked:bg-amber-100 peer-checked:border-amber-400 peer-checked:text-amber-700">
                                                {{ $i }}
                                            </span>
                                        </label>
                                    @endfor
                                </div>

                                <button type="submit"
                                    class="inline-flex items-center rounded-sm bg-emerald-600 px-4 py-2 text-xs sm:text-sm font-medium text-white hover:bg-emerald-700">
                                    Kirim Rating
                                </button>
                            </div>
                        </form>
                    @endif
                @endauth
            </section>

            {{-- Section Komentar --}}
            <section class="bg-white border border-neutral-100 rounded-sm p-6 space-y-5">
                <div class="flex items-center justify-between gap-2">
                    <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                        Komentar
                    </h2>
                    <span
                        class="inline-flex items-center rounded-full bg-neutral-100 px-3 py-1 text-xs font-medium text-neutral-600">
                        {{ $comments->count() }} komentar
                    </span>
                </div>

                {{-- List komentar --}}
                <div class="space-y-4">
                    @forelse($comments as $comment)
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 rounded-full bg-neutral-200 flex items-center justify-center text-xs font-semibold text-neutral-700">
                                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1 border-b border-neutral-100 pb-3 last:border-b-0">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-sm font-semibold text-neutral-800">
                                        {{ $comment->user->name ?? 'User' }}
                                    </p>
                                    <span class="text-xs text-neutral-400 whitespace-nowrap">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="mt-1 text-sm text-neutral-700">
                                    {{ $comment->body }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-600">
                            Belum ada komentar. Jadilah yang pertama untuk berbagi pengalamanmu.
                        </p>
                    @endforelse
                </div>

                {{-- Form komentar / info login --}}
                @auth
                    <form action="{{ route('comments.store', $recipe->id) }}" method="POST"
                        class="pt-4 mt-1 border-t border-neutral-100">
                        @csrf
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 rounded-full bg-neutral-200 flex items-center justify-center text-xs font-semibold text-neutral-700">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1 space-y-2">
                                <div>
                                    <span class="text-sm font-medium text-neutral-800">Tulis komentarmu</span>
                                    <textarea name="body" rows="3"
                                        class="mt-1 w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Bagikan tips, pengalaman memasak, atau penilaianmu tentang resep ini...">{{ old('body') }}</textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit"
                                        class="inline-flex items-center rounded-sm bg-neutral-900 px-4 py-2 text-xs sm:text-sm font-medium text-white hover:bg-neutral-800">
                                        Kirim Komentar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <p class="pt-4 mt-1 border-t border-neutral-100 text-sm text-neutral-600">
                        Silakan <span class="font-medium">login</span> untuk menulis komentar.
                    </p>
                @endauth
            </section>
        </div>

    </div>
@endsection
