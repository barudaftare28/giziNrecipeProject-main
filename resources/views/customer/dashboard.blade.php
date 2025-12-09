{{-- resources/views/customer/dashboard.blade.php --}}
@extends('layouts.customer')

@section('title', 'Beranda | NutriRecipe')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-16">

        {{-- 1. HERO SECTION (Highlight utama) --}}
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            {{-- Text side --}}
            <div class="">
                <p class="text-xs font-semibold tracking-[0.25em] text-neutral-400 uppercase">
                    @if ($userName)
                        Selamat datang, {{ $userName }}
                    @else
                        Selamat datang di NutriRecipe
                    @endif
                </p>

                <h1 class="text-4xl sm:text-4xl font-black tracking-widest uppercase text-neutral-900 mt-2">
                    Resep sehat untuk<br class="hidden sm:block">
                    <span class="text-emerald-600">hari-hari sibukmu.</span>
                </h1>

                <p class="text-base sm:text-sm text-neutral-600 max-w-xl mt-2">
                    Temukan inspirasi menu dari pakar gizi dan komunitas, simpan favoritmu,
                    dan mulai berbagi resep andalanmu sendiri di NutriRecipe.
                </p>

                <div class="flex flex-wrap gap-3 pt-1 mt-12">
                    <a href="{{ route('customer.recipes.create-rules') }}"
                        class="inline-flex items-center gap-2 rounded-sm bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white tracking-wide hover:bg-emerald-700">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Buat Resep Sehatmu</span>
                    </a>

                    <a href="{{ route('customer.recipes.index') }}"
                        class="inline-flex items-center gap-2 rounded-sm bg-neutral-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-neutral-800">
                        Jelajahi Semua Resep
                    </a>
                </div>

                <div class="flex flex-wrap gap-6 text-xs text-neutral-500 mt-2">
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        <span>Resep official dari pakar gizi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        <span>Komposisi gizi transparan</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        <span>Bisa disimpan sebagai favorit</span>
                    </div>
                </div>
            </div>

            {{-- Visual side: hero highlight recipe --}}
            <div class="relative h-64 sm:h-80 lg:h-96 rounded-sm overflow-hidden ">
                @php
                    $heroImage = $heroRecipe?->photo
                        ? $heroRecipe->photo_url ?? asset('storage/' . $heroRecipe->photo)
                        : 'https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=1200';
                @endphp

                <img src="{{ $heroImage }}" alt="{{ $heroRecipe->name ?? 'NutriRecipe Highlight' }}"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-black/75 via-black/40 to-black/10"></div>

                <div class="absolute inset-0 p-6 sm:p-8 flex flex-col justify-between text-white">
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-white/70">
                            @if ($heroRecipe?->is_official)
                                Resep Official Pilihan
                            @else
                                Highlight Hari Ini
                            @endif
                        </p>
                        <p class="text-xl sm:text-4xl font-bold leading-snug line-clamp-2">
                            {{ $heroRecipe->name ?? 'Masak makanan rumahan yang tetap ramah kalori.' }}
                        </p>
                        @if ($heroRecipe)
                            <p style="width: 70%" class="text-xs text-white/80 line-clamp-2">
                                {{ $heroRecipe->description ?? 'Resep pilihan dengan komposisi gizi seimbang untuk hari-hari sibukmu.' }}
                            </p>
                        @endif
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        @if ($heroRecipe)
                            <div class="text-white/70 space-y-0.5">
                                <p class="text-sm uppercase font-semibold">{{ $heroRecipe->duration }}</p>
                                @if ($heroRecipe->ratings_avg_rating)
                                    <p class="text-sm">
                                        <span class="text-yellow-500">★
                                            {{ number_format($heroRecipe->ratings_avg_rating, 1) }} </span>
                                        | {{ $heroRecipe->ratings_count ?? 0 }} rating
                                    </p>
                                @endif
                            </div>
                        @endif

                        @if ($heroRecipe)
                            <a href="{{ route('customer.recipes.show', $heroRecipe->id) }}"
                                class="inline-flex items-center gap-2 rounded-sm bg-emerald-600 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide hover:bg-emerald-700">
                                Lihat Resep
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        @else
                            <a href="{{ route('customer.recipes.index') }}"
                                class="inline-flex items-center gap-2 rounded-sm bg-emerald-600 px-3 py-1.5 text-xs font-semibold uppercase tracking-wide hover:bg-emerald-700">
                                Jelajahi Resep
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        @endif


                    </div>
                </div>
            </div>
        </section>

        {{-- 2. "JANGAN TERLEWAT" / DON'T MISS (CAROUSEL) --}}
        <section class="space-y-2">
            <section class="space-y-2">
                <div class="flex items-center justify-between gap-2">
                    <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                        Jangan Terlewat
                    </h2>
                    <a href="{{ route('customer.recipes.index') }}"
                        class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                        Lihat semua →
                    </a>
                </div>

                @if ($dontMissRecipes->isEmpty())
                    <p class="text-sm text-neutral-500">
                        Belum ada resep yang bisa ditampilkan di bagian ini.
                    </p>
                @else
                    <div class="relative">
                        {{-- Tombol prev/next (desktop) --}}
                        <button type="button"
                            class="hidden md:flex absolute left-2 top-1/2 -translate-y-1/2 z-10 h-9 w-9 items-center justify-center rounded-full bg-white/90 shadow border border-neutral-200 text-neutral-600 hover:bg-neutral-100"
                            onclick="nutriCarouselScroll('dont-miss-carousel', -1)">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                        </button>

                        <button type="button"
                            class="hidden md:flex absolute right-2 top-1/2 -translate-y-1/2 z-10 h-9 w-9 items-center justify-center rounded-full bg-white/90 shadow border border-neutral-200 text-neutral-600 hover:bg-neutral-100"
                            onclick="nutriCarouselScroll('dont-miss-carousel', 1)">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </button>

                        {{-- CAROUSEL --}}
                        <div id="dont-miss-carousel"
                            class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory pb-2">
                            @foreach ($dontMissRecipes as $recipe)
                                @php
                                    $img = $recipe->photo
                                        ? $recipe->photo_url ?? asset('storage/' . $recipe->photo)
                                        : 'https://placehold.co/800x600/e2e8f0/e2e8f0?text=NutriRecipe';
                                @endphp

                                <a href="{{ route('customer.recipes.show', $recipe->id) }}"
                                    class="nutri-dontmiss-slide snap-start flex-shrink-0 w-[85%] sm:w-[70%] md:w-[420px] lg:w-[480px] group relative h-52 sm:h-64 overflow-hidden rounded-sm">
                                    <img src="{{ $img }}" alt="{{ $recipe->name }}"
                                        class="w-full h-full object-cover group-hover:brightness-95 transition">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent">
                                    </div>

                                    <div class="absolute inset-0 p-4 flex flex-col justify-end text-white">
                                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-white/70 mb-1">
                                            {{ $recipe->is_official ? 'Resep Official' : 'Resep Komunitas' }}
                                        </p>
                                        <p class="text-sm sm:text-base font-semibold line-clamp-2">
                                            {{ $recipe->name }}
                                        </p>
                                        <div class="mt-1 flex items-center justify-between text-xs text-white/70">
                                            <span>{{ $recipe->duration }}</span>
                                            @if ($recipe->ratings_avg_rating)
                                                <span class="text-yellow-500">★
                                                    {{ number_format($recipe->ratings_avg_rating, 1) }}</span>
                                            @else
                                                <span>Belum ada rating</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </section>

            <script>
                function nutriCarouselScroll(id, direction) {
                    const container = document.getElementById(id);
                    if (!container) return;

                    const slide = container.querySelector('.nutri-dontmiss-slide');
                    const gap = 16; // kira-kira gap-4
                    const scrollAmount = slide ? slide.offsetWidth + gap : container.offsetWidth;

                    container.scrollBy({
                        left: direction * scrollAmount,
                        behavior: 'smooth'
                    });
                }
            </script>


            {{-- 3. QUICK FILTERS + STAT CARDS --}}
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                {{-- Quick filter chips --}}
                <div class="lg:col-span-2 bg-white border border-neutral-100 rounded-sm p-4 sm:p-5">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                            Cari ide menu berdasarkan suasana
                        </h2>
                        <a href="{{ route('customer.recipes.index') }}"
                            class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                            Lihat semua resep →
                        </a>
                    </div>

                    <div class="flex flex-wrap gap-2 text-xs">
                        @php
                            $chips = [
                                'Sarapan Cepat',
                                'Makan Siang Ringan',
                                'Makan Malam Keluarga',
                                'Snack Sehat',
                                'Low Calories',
                                'High Protein',
                                'Tanpa Goreng',
                                '30 Menit Saja',
                            ];
                        @endphp

                        @foreach ($chips as $chip)
                            <button type="button"
                                class="inline-flex items-center rounded-full border border-neutral-200 bg-neutral-50 px-3 py-1 text-xs font-medium text-neutral-700 hover:bg-neutral-100">
                                {{ $chip }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Bar kecil untuk “search” yang mengarahkan ke halaman resep --}}
                    <form action="{{ route('customer.recipes.index') }}" method="GET" class="mt-20 flex gap-2">
                        <input type="text" name="search"
                            placeholder="Cari resep berdasarkan nama, durasi, atau pembuat..."
                            class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600">
                        <button type="submit"
                            class="inline-flex items-center rounded-sm bg-neutral-900 px-4 py-2 text-xs sm:text-sm font-semibold text-white hover:bg-neutral-800">
                            Cari
                        </button>
                    </form>
                </div>

                {{-- Stat cards --}}
                <div class="space-y-2">
                    <div class="bg-white border border-neutral-100 rounded-sm  p-4">
                        <p class="text-xs font-semibold text-neutral-500 uppercase tracking-[0.2em]">
                            Resep Tersedia
                        </p>
                        <p class="mt-2 text-2xl font-semibold text-neutral-900">{{ $recipeCount }}</p>
                        <p class="mt-1 text-xs text-neutral-500">
                            Jelajahi resep official dan komunitas yang sudah dikurasi tim NutriRecipe.
                        </p>
                    </div>

                    <div class="bg-white border border-neutral-100 rounded-sm  p-4">
                        <p class="text-xs font-semibold text-neutral-500 uppercase tracking-[0.2em]">
                            Resep Favoritmu
                        </p>
                        <p class="mt-2 text-2xl font-semibold text-neutral-900">{{ $bookmarksCount }}</p>
                        <p class="mt-1 text-xs text-neutral-500">
                            Simpan resep pilihanmu dan ulangi kapan saja tanpa perlu mencarinya lagi.
                        </p>
                    </div>
                </div>
            </section>

        </section>



        {{-- 4. RESEP OFFICIAL PAKAR GIZI --}}
        <section class="space-y-2">
            <div class="flex items-center justify-between gap-2">
                <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                    Koleksi Resep Official Pakar Gizi
                </h2>
                <a href="{{ route('customer.recipes.index', ['type' => 'official']) }}"
                    class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                    Lihat semua official →
                </a>
            </div>

            @if ($officialRecipes->isEmpty())
                <p class="text-sm text-neutral-500">Belum ada resep official yang diposting.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                    @foreach ($officialRecipes as $recipe)
                        @php
                            $img = $recipe->photo
                                ? $recipe->photo_url ?? asset('storage/' . $recipe->photo)
                                : 'https://placehold.co/600x400/e2e8f0/e2e8f0?text=NutriRecipe';
                        @endphp

                        <a href="{{ route('customer.recipes.show', $recipe->id) }}"
                            class="group bg-white border border-neutral-100 rounded-sm overflow-hidden  hover: transition flex flex-col">
                            <div class="relative h-40 overflow-hidden">
                                <img src="{{ $img }}" alt="{{ $recipe->name }}"
                                    class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform">
                                <span
                                    class="absolute top-3 left-3 inline-flex items-center rounded-full bg-emerald-50/95 px-3 py-1 text-[10px] font-semibold uppercase tracking-wide text-emerald-700">
                                    Official
                                </span>
                            </div>
                            <div class="p-4 flex-1 flex flex-col gap-1">
                                <p class="text-xs text-neutral-500">
                                    Oleh Pakar Gizi
                                </p>
                                <p class="text-sm font-semibold text-neutral-900 line-clamp-2">
                                    {{ $recipe->name }}
                                </p>
                                <p class="text-xs text-neutral-500 line-clamp-2">
                                    {{ $recipe->description }}
                                </p>
                                <div class="mt-2 flex items-center justify-between text-xs text-neutral-500">
                                    <span>{{ $recipe->duration }}</span>
                                    @if ($recipe->ratings_avg_rating)
                                        <span class="text-yellow-500">★
                                            {{ number_format($recipe->ratings_avg_rating, 1) }}</span>
                                    @else
                                        <span class="italic">Belum ada rating</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- 5. RESEP KOMUNITAS TERBARU --}}
        <section class="space-y-2">
            <div class="flex items-center justify-between gap-2">
                <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                    Resep Komunitas Terbaru
                </h2>
                <a href="{{ route('customer.recipes.index', ['type' => 'komunitas']) }}"
                    class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                    Jelajahi resep komunitas →
                </a>
            </div>

            @if ($communityRecipes->isEmpty())
                <p class="text-sm text-neutral-500">Belum ada resep dari komunitas yang ditambahkan.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    @foreach ($communityRecipes as $recipe)
                        @php
                            $img = $recipe->photo
                                ? $recipe->photo_url ?? asset('storage/' . $recipe->photo)
                                : 'https://placehold.co/600x400/e2e8f0/e2e8f0?text=NutriRecipe';
                        @endphp

                        <a href="{{ route('customer.recipes.show', $recipe->id) }}"
                            class="group bg-white border border-neutral-100 rounded-sm overflow-hidden  hover: transition flex flex-col">
                            <div class="relative h-32 overflow-hidden">
                                <img src="{{ $img }}" alt="{{ $recipe->name }}"
                                    class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform">
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <p class="text-xs text-neutral-500">
                                    Oleh {{ $recipe->user->name ?? 'User NutriRecipe' }}
                                </p>
                                <p class="mt-1 text-sm font-semibold text-neutral-900 line-clamp-2">
                                    {{ $recipe->name }}
                                </p>
                                <div class="mt-auto flex items-center justify-between text-xs text-neutral-500 pt-2">
                                    <span>{{ $recipe->duration }}</span>
                                    @if ($recipe->ratings_avg_rating)
                                        <span class="text-yellow-500">★
                                            {{ number_format($recipe->ratings_avg_rating, 1) }}</span>
                                    @else
                                        <span class="italic">Belum ada rating</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- 6. RESEP CEPAT & PRAKTIS --}}
        <section class="space-y-2">
            <div class="flex items-center justify-between gap-2">
                <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                    Cepat & Praktis (± 30 Menit)
                </h2>
                <a href="{{ route('customer.recipes.index') }}?search=30%20menit"
                    class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                    Cari resep cepat lainnya →
                </a>
            </div>

            @if ($quickRecipes->isEmpty())
                <p class="text-sm text-neutral-500">Belum ada resep yang dikategorikan sebagai menu cepat.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                    @foreach ($quickRecipes as $recipe)
                        @php
                            $img = $recipe->photo
                                ? $recipe->photo_url ?? asset('storage/' . $recipe->photo)
                                : 'https://placehold.co/600x400/e2e8f0/e2e8f0?text=NutriRecipe';
                        @endphp

                        <a href="{{ route('customer.recipes.show', $recipe->id) }}"
                            class="group bg-white border border-neutral-100 rounded-sm overflow-hidden  hover: transition flex flex-col">
                            <div class="relative h-32 overflow-hidden">
                                <img src="{{ $img }}" alt="{{ $recipe->name }}"
                                    class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform">
                            </div>
                            <div class="p-4 flex-1 flex flex-col gap-1">
                                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-[0.15em]">
                                    Cepat & Praktis
                                </p>
                                <p class="text-sm font-semibold text-neutral-900 line-clamp-2">
                                    {{ $recipe->name }}
                                </p>
                                <p class="text-xs text-neutral-500">
                                    {{ $recipe->duration }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- 7. FAN FAVORITES (rating tertinggi) --}}
        <section class="space-y-2">
            <div class="flex items-center justify-between gap-2">
                <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                    Fan Favorites – Paling Disukai
                </h2>
                <a href="{{ route('customer.recipes.index') }}?sort=rating"
                    class="text-xs font-semibold text-emerald-700 hover:text-emerald-900">
                    Lihat semua favorit →
                </a>
            </div>

            @if ($fanFavorites->isEmpty())
                <p class="text-sm text-neutral-500">
                    Belum ada rating yang cukup untuk menampilkan favorit.
                </p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($fanFavorites as $recipe)
                        @php
                            $img = $recipe->photo
                                ? $recipe->photo_url ?? asset('storage/' . $recipe->photo)
                                : 'https://placehold.co/400x300/e2e8f0/e2e8f0?text=NutriRecipe';
                        @endphp

                        <a href="{{ route('customer.recipes.show', $recipe->id) }}"
                            class="group bg-white border border-neutral-100 rounded-sm overflow-hidden  hover: transition flex flex-col">
                            <div class="h-28 overflow-hidden">
                                <img src="{{ $img }}" alt="{{ $recipe->name }}"
                                    class="w-full h-full object-cover group-hover:scale-[1.04] transition-transform">
                            </div>
                            <div class="p-3 flex-1 flex flex-col gap-1">
                                <p class="text-xs text-neutral-500 line-clamp-1">
                                    {{ $recipe->is_official ? 'Resep Official' : 'Resep Komunitas' }}
                                </p>
                                <p class="text-sm font-semibold text-neutral-900 line-clamp-2">
                                    {{ $recipe->name }}
                                </p>
                                <div class="mt-auto flex items-center justify-between text-xs text-neutral-500 pt-1">
                                    <span class="text-yellow-500">★
                                        {{ number_format($recipe->ratings_avg_rating, 1) }}</span>
                                    <span>{{ $recipe->duration }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- SECTION: Koleksi Kurasi (Carousel) + FAQ Gizi (Accordion) --}}
        <section class="space-y-2">
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                {{-- CAROUSEL – Koleksi Kurasi --}}
                <div class="bg-white border border-neutral-100 rounded-sm  p-5">
                    <div class="flex items-center justify-between gap-2 mb-6">
                        <div>
                            <p class="text-xs font-semibold tracking-[0.25em] uppercase text-neutral-400">
                                Koleksi Kurasi
                            </p>
                            <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                                Ide menu siap pakai untuk berbagai momen
                            </h2>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-neutral-200 text-neutral-500 hover:bg-neutral-100"
                                onclick="nutriCarouselScroll('nutri-collections-carousel', -1)">
                                <i class="fa-solid fa-chevron-left text-[10px]"></i>
                            </button>
                            <button type="button"
                                class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-neutral-200 text-neutral-500 hover:bg-neutral-100"
                                onclick="nutriCarouselScroll('nutri-collections-carousel', 1)">
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </button>
                        </div>
                    </div>

                    <div id="nutri-collections-carousel"
                        class="flex gap-4 overflow-x-auto scroll-smooth snap-x snap-mandatory pb-2">
                        {{-- Card 1 --}}
                        <a href="{{ route('customer.recipes.index', ['search' => 'dinner']) }}"
                            class="min-w-[220px] max-w-[240px] snap-start bg-neutral-900 rounded-sm overflow-hidden relative text-white flex-shrink-0">
                            <img src="https://images.pexels.com/photos/3298180/pexels-photo-3298180.jpeg?auto=compress&cs=tinysrgb&w=1200"
                                alt="Makan malam keluarga" class="w-full h-32 object-cover opacity-70">
                            <div class="p-4 space-y-1">
                                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/70">
                                    Koleksi
                                </p>
                                <p class="text-sm font-semibold">
                                    25 Ide Makan Malam Keluarga
                                </p>
                                <p class="text-xs text-white/75">
                                    Menu hangat untuk dinikmati bersama, tanpa ribet.
                                </p>
                            </div>
                        </a>

                        {{-- Card 2 --}}
                        <a href="{{ route('customer.recipes.index', ['search' => 'sarapan']) }}"
                            class="min-w-[220px] max-w-[240px] snap-start bg-white border border-neutral-200 rounded-sm overflow-hidden flex-shrink-0">
                            <img src="https://images.pexels.com/photos/5710170/pexels-photo-5710170.jpeg?auto=compress&cs=tinysrgb&w=1200"
                                alt="Sarapan cepat" class="w-full h-32 object-cover">
                            <div class="p-4 space-y-1">
                                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-emerald-600">
                                    Cepat & Praktis
                                </p>
                                <p class="text-sm font-semibold text-neutral-900">
                                    15 Sarapan Siap dalam 15 Menit
                                </p>
                                <p class="text-xs text-neutral-500">
                                    Untuk pagi sibuk ketika tetap ingin makan bergizi.
                                </p>
                            </div>
                        </a>

                        {{-- Card 3 --}}
                        <a href="{{ route('customer.recipes.index', ['search' => 'snack']) }}"
                            class="min-w-[220px] max-w-[240px] snap-start bg-white border border-neutral-200 rounded-sm overflow-hidden flex-shrink-0">
                            <img src="https://images.pexels.com/photos/4109990/pexels-photo-4109990.jpeg?auto=compress&cs=tinysrgb&w=1200"
                                alt="Snack sehat" class="w-full h-32 object-cover">
                            <div class="p-4 space-y-1">
                                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-emerald-600">
                                    Snack Sehat
                                </p>
                                <p class="text-sm font-semibold text-neutral-900">
                                    20 Ide Cemilan Rendah Kalori
                                </p>
                                <p class="text-xs text-neutral-500">
                                    Cocok untuk teman kerja, belajar, atau nonton.
                                </p>
                            </div>
                        </a>

                        {{-- Card 4 --}}
                        <a href="{{ route('customer.recipes.index', ['search' => 'high protein']) }}"
                            class="min-w-[220px] max-w-[240px] snap-start bg-neutral-900 rounded-sm overflow-hidden relative text-white flex-shrink-0">
                            <img src="https://images.pexels.com/photos/3296273/pexels-photo-3296273.jpeg?auto=compress&cs=tinysrgb&w=1200"
                                alt="High protein" class="w-full h-32 object-cover opacity-70">
                            <div class="p-4 space-y-1">
                                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/70">
                                    Fokus Protein
                                </p>
                                <p class="text-sm font-semibold">
                                    18 Menu High-Protein Friendly
                                </p>
                                <p class="text-xs text-white/75">
                                    Bantu jaga massa otot, cocok untuk kamu yang aktif.
                                </p>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- ACCORDION – FAQ Gizi & Pemilihan Resep --}}
                <div class="bg-white border border-neutral-100 rounded-sm  p-5">
                    <div class="gap-2 mb-6">
                        <p class="text-xs font-semibold tracking-[0.25em] uppercase text-neutral-400">
                            FAQ Gizi Singkat
                        </p>
                        <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                            Butuh panduan sebelum memilih resep?
                        </h2>
                    </div>

                    <div class="space-y-2 text-sm">
                        <details class="group border border-neutral-200 rounded-sm px-3 py-2">
                            <summary class="flex items-center justify-between cursor-pointer list-none">
                                <span class="font-medium text-neutral-800">
                                    Bagaimana cara tahu resep ini cocok untuk dietku?
                                </span>
                                <i
                                    class="fa-solid fa-chevron-down text-[10px] text-neutral-400 group-open:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="mt-2 text-xs text-neutral-600">
                                Perhatikan ringkasan gizi di setiap resep: kalori, protein, lemak, dan karbohidrat.
                                Sesuaikan dengan target harianmu, dan gunakan fitur bookmark untuk menyimpan resep
                                yang paling cocok.
                            </p>
                        </details>

                        <details class="group border border-neutral-200 rounded-sm px-3 py-2">
                            <summary class="flex items-center justify-between cursor-pointer list-none">
                                <span class="font-medium text-neutral-800">
                                    Apa bedanya resep official dan resep komunitas?
                                </span>
                                <i
                                    class="fa-solid fa-chevron-down text-[10px] text-neutral-400 group-open:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="mt-2 text-xs text-neutral-600">
                                Resep <span class="font-semibold">official</span> disusun dan dicek oleh pakar gizi
                                NutriRecipe,
                                sementara resep <span class="font-semibold">komunitas</span> dibuat oleh pengguna.
                                Kamu bisa mengandalkan label official untuk rekomendasi awal,
                                lalu jelajahi komunitas untuk variasi yang lebih luas.
                            </p>
                        </details>

                        <details class="group border border-neutral-200 rounded-sm px-3 py-2">
                            <summary class="flex items-center justify-between cursor-pointer list-none">
                                <span class="font-medium text-neutral-800">
                                    Kalau waktuku terbatas, resep mana yang sebaiknya kupilih?
                                </span>
                                <i
                                    class="fa-solid fa-chevron-down text-[10px] text-neutral-400 group-open:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="mt-2 text-xs text-neutral-600">
                                Cari resep dengan durasi sekitar <span class="font-semibold">±30 menit</span> atau gunakan
                                koleksi <span class="font-semibold">“Cepat & Praktis”</span> di halaman ini.
                                Estimasi waktu masak selalu kami tampilkan di setiap kartu resep.
                            </p>
                        </details>

                        <details class="group border border-neutral-200 rounded-sm px-3 py-2">
                            <summary class="flex items-center justify-between cursor-pointer list-none">
                                <span class="font-medium text-neutral-800">
                                    Bolehkah aku memodifikasi bahan pada resep?
                                </span>
                                <i
                                    class="fa-solid fa-chevron-down text-[10px] text-neutral-400 group-open:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="mt-2 text-xs text-neutral-600">
                                Tentu. Kamu bisa mengganti bahan dengan opsi yang lebih sesuai preferensi
                                atau alergi tertentu. Gunakan bagian catatan pribadi (jika ada) atau simpan versi
                                modifikasi sebagai resep baru untuk membantumu di masa depan.
                            </p>
                        </details>
                    </div>
                </div>
            </section>

            {{-- SCRIPT KECIL UNTUK CAROUSEL --}}
            <script>
                function nutriCarouselScroll(id, direction) {
                    const container = document.getElementById(id);
                    if (!container) return;

                    const card = container.querySelector('a');
                    const scrollAmount = card ? card.offsetWidth + 16 : 260; // lebar kartu + gap

                    container.scrollBy({
                        left: direction * scrollAmount,
                        behavior: 'smooth'
                    });
                }
            </script>

            {{-- 8. EDU / TIPS SECTION --}}
            <section class="bg-white border border-neutral-100 rounded-sm p-5 md:p-6">
                <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900 mb-4">
                    Tips singkat: bagaimana memilih resep yang tepat?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-neutral-600">
                    <div class="space-y-1">
                        <p class="font-semibold text-neutral-800">1. Sesuaikan dengan waktumu</p>
                        <p class="text-sm">
                            Pilih durasi yang realistis dengan jadwalmu. NutriRecipe memudahkan kamu melihat estimasi waktu
                            di setiap resep.
                        </p>
                    </div>
                    <div class="space-y-1">
                        <p class="font-semibold text-neutral-800">2. Perhatikan komposisi gizi</p>
                        <p class="text-sm">
                            Lihat kandungan kalori, protein, lemak, dan karbohidrat untuk menyeimbangkan kebutuhan harianmu.
                        </p>
                    </div>
                    <div class="space-y-1">
                        <p class="font-semibold text-neutral-800">3. Simpan & bagikan yang cocok</p>
                        <p class="text-sm">
                            Jika sudah cocok, simpan ke favorit. Kalau punya versi lebih sehat, unggah resep versimu
                            agar bermanfaat untuk pengguna lain.
                        </p>
                    </div>
                </div>
            </section>
        </section>

    </div>
@endsection
