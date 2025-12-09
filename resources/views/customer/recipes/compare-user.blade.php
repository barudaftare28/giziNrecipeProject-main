{{-- resources/views/customer/recipes/compare-user.blade.php --}}
@extends('layouts.customer')

@section('title', 'Bandingkan Resep | NutriRecipe')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- Header --}}
        <section class="space-y-2">
            <h1 class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-neutral-900">
                Bandingkan Resep
            </h1>

            @if ($recipe1)
                <p class="max-w-2xl text-sm text-neutral-500">
                    Pilih dua resep untuk dibandingkan secara berdampingan.
                    Kamu sedang menjadikan
                    <span class="font-semibold text-neutral-800">{{ $recipe1->name }}</span>
                    sebagai resep pertama.
                </p>
            @else
                <p class="max-w-2xl text-sm text-neutral-500">
                    Mulai dengan memilih resep pertama yang ingin kamu jadikan acuan, lalu pilih resep pembandingnya.
                </p>
            @endif
        </section>

        @if (!$recipe1)
            {{-- STATE: Belum memilih resep pertama (akses dari navbar) --}}
            <section class="bg-white border border-neutral-100 rounded-sm p-6 space-y-4">
                <p class="text-xs font-bold tracking-wider uppercase text-neutral-400">
                    Pilih Resep Pertama
                </p>
                <p class="text-sm text-neutral-600">
                    Mulai dengan memilih satu resep yang ingin kamu jadikan patokan perbandingan.
                </p>

                <form action="{{ route('customer.recipes.compare') }}" method="GET" class="space-y-3">
                    <label class="block text-xs font-medium text-neutral-700 mb-1">
                        Resep pertama
                    </label>
                    <select name="recipe1"
                        class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        required>
                        <option value="" disabled selected>-- Pilih salah satu resep --</option>
                        @foreach ($otherRecipes as $r)
                            <option value="{{ $r->id }}">
                                {{ $r->name }} {{ $r->is_official ? '(Official)' : '' }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit"
                        class="inline-flex items-center rounded-sm bg-neutral-900 px-4 py-2 text-xs sm:text-sm font-medium text-white hover:bg-neutral-800">
                        Lanjutkan
                    </button>
                </form>
            </section>
        @else
            {{-- STATE: Sudah memilih resep pertama (dan mungkin resep kedua) --}}
            {{-- Dua kolom: resep pertama & slot resep kedua --}}
            <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Resep 1 --}}
                <div class="bg-white border border-neutral-100 rounded-sm p-5 space-y-3">
                    <p class="text-xs font-bold tracking-wider uppercase text-neutral-400">
                        Resep Pertama
                    </p>

                    <h2 class="text-lg font-semibold text-neutral-900">
                        {{ $recipe1->name }}
                    </h2>

                    <p class="text-xs text-neutral-500">
                        Oleh:
                        @if ($recipe1->is_official)
                            <span class="font-medium text-neutral-800">
                                Pakar Gizi ({{ $recipe1->nutritionist }})
                            </span>
                        @else
                            <span class="font-medium text-neutral-800">
                                {{ $recipe1->user->name ?? 'User' }}
                            </span>
                        @endif
                    </p>

                    <p
                        class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-wide
                    {{ $recipe1->is_official ? 'bg-emerald-50 text-emerald-700' : 'bg-neutral-100 text-neutral-500' }}">
                        {{ $recipe1->is_official ? 'Resep Official' : 'Resep Komunitas' }}
                    </p>

                    @if ($recipe1->duration)
                        <p class="text-xs text-neutral-500 mt-1">
                            Durasi: <span class="font-medium text-neutral-800">{{ $recipe1->duration }}</span>
                        </p>
                    @endif

                    @if ($recipe1->description)
                        <p class="mt-2 text-sm text-neutral-600 line-clamp-3">
                            {{ \Illuminate\Support\Str::limit($recipe1->description, 160) }}
                        </p>
                    @endif
                </div>

                {{-- Resep 2 / Pemilihan --}}
                <div class="bg-white border border-neutral-100 rounded-sm p-5 space-y-4">
                    <p class="text-xs font-bold tracking-wider uppercase text-neutral-400">
                        Resep Pembanding
                    </p>

                    @if (!$recipe2)
                        {{-- State: belum ada resep kedua, tampilkan form pilih --}}
                        <p class="text-sm text-neutral-600">
                            Pilih satu resep lain untuk dibandingkan dengan
                            <span class="font-semibold text-neutral-800">{{ $recipe1->name }}</span>.
                        </p>

                        <form action="{{ route('customer.recipes.compare') }}" method="GET" class="space-y-3">
                            {{-- kirim recipe1 sebagai hidden --}}
                            <input type="hidden" name="recipe1" value="{{ $recipe1->id }}">

                            <label class="block text-xs font-medium text-neutral-700 mb-1">
                                Pilih resep kedua
                            </label>
                            <select name="recipe2"
                                class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required>
                                <option value="" disabled selected>-- Pilih salah satu resep --</option>
                                @foreach ($otherRecipes as $r)
                                    <option value="{{ $r->id }}">
                                        {{ $r->name }} {{ $r->is_official ? '(Official)' : '' }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                class="inline-flex items-center rounded-sm bg-emerald-600 px-4 py-2 text-xs sm:text-sm font-medium text-white hover:bg-emerald-700">
                                Bandingkan
                            </button>
                        </form>
                    @else
                        {{-- State: sudah ada dua resep, tampilkan ringkasan resep pembanding --}}
                        <h2 class="text-lg font-semibold text-neutral-900">
                            {{ $recipe2->name }}
                        </h2>

                        <p class="text-xs text-neutral-500">
                            Oleh:
                            @if ($recipe2->is_official)
                                <span class="font-medium text-neutral-800">
                                    Pakar Gizi ({{ $recipe2->nutritionist }})
                                </span>
                            @else
                                <span class="font-medium text-neutral-800">
                                    {{ $recipe2->user->name ?? 'User' }}
                                </span>
                            @endif
                        </p>

                        <p
                            class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-semibold uppercase tracking-wide
                            {{ $recipe2->is_official ? 'bg-emerald-50 text-emerald-700' : 'bg-neutral-100 text-neutral-500' }}">
                            {{ $recipe2->is_official ? 'Resep Official' : 'Resep Komunitas' }}
                        </p>

                        @if ($recipe2->duration)
                            <p class="text-xs text-neutral-500 mt-1">
                                Durasi: <span class="font-medium text-neutral-800">{{ $recipe2->duration }}</span>
                            </p>
                        @endif

                        @if ($recipe2->description)
                            <p class="mt-2 text-sm text-neutral-600 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit($recipe2->description, 160) }}
                            </p>
                        @endif

                        <div class="pt-3 border-t border-neutral-100 mt-3">
                            <a href="{{ route('customer.recipes.compare', ['recipe1' => $recipe1->id]) }}"
                                class="inline-flex items-center rounded-sm border border-neutral-300 bg-white px-3 py-1.5 text-[11px] font-medium text-neutral-700 hover:bg-neutral-50">
                                Ganti resep pembanding
                            </a>
                        </div>
                    @endif

                </div>
            </section>
        @endif

        {{-- Perbandingan detail, hanya jika resep kedua sudah dipilih --}}
        @if ($recipe2)
            <section class="bg-white border border-neutral-100 rounded-sm p-6 space-y-6 mt-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h2 class="text-sm font-bold tracking-wider uppercase text-neutral-900">
                            Perbandingan Detail
                        </h2>
                        <p class="text-xs sm:text-sm text-neutral-500 mt-1">
                            Melihat dua resep berdampingan membantu kamu memilih mana yang paling pas dengan kebutuhan gizi
                            dan waktumu.
                        </p>
                    </div>
                    <div class="text-xs text-neutral-500">
                        <span class="font-semibold text-neutral-800">{{ $recipe1->name }}</span>
                        <span class="mx-1">vs</span>
                        <span class="font-semibold text-neutral-800">{{ $recipe2->name }}</span>
                    </div>
                </div>

                {{-- Info dasar --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900">
                            Info Dasar
                        </h3>
                        <p class="text-sm font-semibold text-neutral-900">
                            {{ $recipe1->name }}
                        </p>
                        <p class="text-xs text-neutral-500">
                            {{ $recipe1->is_official ? 'Resep Official' : 'Resep Komunitas' }} &middot;
                            {{ $recipe1->duration ?? '-' }}
                        </p>
                        <p class="text-xs text-neutral-500">
                            Oleh:
                            @if ($recipe1->is_official)
                                <span class="font-medium text-neutral-800">Pakar Gizi ({{ $recipe1->nutritionist }})</span>
                            @else
                                <span class="font-medium text-neutral-800">{{ $recipe1->user->name ?? 'User' }}</span>
                            @endif
                        </p>
                    </div>

                    <div class="space-y-2">
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900">
                            &nbsp;
                        </h3>
                        <p class="text-sm font-semibold text-neutral-900">
                            {{ $recipe2->name }}
                        </p>
                        <p class="text-xs text-neutral-500">
                            {{ $recipe2->is_official ? 'Resep Official' : 'Resep Komunitas' }} &middot;
                            {{ $recipe2->duration ?? '-' }}
                        </p>
                        <p class="text-xs text-neutral-500">
                            Oleh:
                            @if ($recipe2->is_official)
                                <span class="font-medium text-neutral-800">Pakar Gizi ({{ $recipe2->nutritionist }})</span>
                            @else
                                <span class="font-medium text-neutral-800">{{ $recipe2->user->name ?? 'User' }}</span>
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Rating & Aktivitas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1">
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900">
                            Rating & Aktivitas
                        </h3>
                        <p class="text-sm text-neutral-700">
                            Rating:
                            @if ($recipe1->ratings_count > 0)
                                <span class="font-semibold">
                                    {{ number_format($recipe1->ratings_avg_rating, 1) }} / 5
                                </span>
                                <span class="text-xs text-neutral-500">
                                    ({{ $recipe1->ratings_count }} rating)
                                </span>
                            @else
                                <span class="text-xs text-neutral-500">Belum ada rating</span>
                            @endif
                        </p>
                        <p class="text-xs text-neutral-500">
                            {{ $recipe1->comments_count }} komentar
                        </p>
                    </div>

                    <div class="space-y-1">
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900">
                            &nbsp;
                        </h3>
                        <p class="text-sm text-neutral-700">
                            Rating:
                            @if ($recipe2->ratings_count > 0)
                                <span class="font-semibold">
                                    {{ number_format($recipe2->ratings_avg_rating, 1) }} / 5
                                </span>
                                <span class="text-xs text-neutral-500">
                                    ({{ $recipe2->ratings_count }} rating)
                                </span>
                            @else
                                <span class="text-xs text-neutral-500">Belum ada rating</span>
                            @endif
                        </p>
                        <p class="text-xs text-neutral-500">
                            {{ $recipe2->comments_count }} komentar
                        </p>
                    </div>
                </div>

                {{-- Bahan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900 mb-2">
                            Alat & Bahan
                        </h3>
                        @if ($recipe1->ingredients->isEmpty())
                            <p class="text-xs text-neutral-500">Bahan tidak tersedia.</p>
                        @else
                            <ul class="list-disc list-inside space-y-1 text-sm text-neutral-700">
                                @foreach ($recipe1->ingredients as $ingredient)
                                    <li>{{ $ingredient->item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900 mb-2">
                            Alat & Bahan
                        </h3>
                        @if ($recipe2->ingredients->isEmpty())
                            <p class="text-xs text-neutral-500">Bahan tidak tersedia.</p>
                        @else
                            <ul class="list-disc list-inside space-y-1 text-sm text-neutral-700">
                                @foreach ($recipe2->ingredients as $ingredient)
                                    <li>{{ $ingredient->item }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- Informasi Gizi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900 mb-2">
                            Informasi Gizi
                        </h3>
                        @if ($recipe1->nutritions->isEmpty())
                            <p class="text-xs text-neutral-500">Informasi gizi tidak tersedia.</p>
                        @else
                            <ul class="space-y-1 text-sm text-neutral-700">
                                @foreach ($recipe1->nutritions as $nutrition)
                                    <li class="flex items-center justify-between gap-2">
                                        <span>{{ $nutrition->name }}</span>
                                        <span class="font-medium">{{ $nutrition->value }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900 mb-2">
                            Informasi Gizi
                        </h3>
                        @if ($recipe2->nutritions->isEmpty())
                            <p class="text-xs text-neutral-500">Informasi gizi tidak tersedia.</p>
                        @else
                            <ul class="space-y-1 text-sm text-neutral-700">
                                @foreach ($recipe2->nutritions as $nutrition)
                                    <li class="flex items-center justify-between gap-2">
                                        <span>{{ $nutrition->name }}</span>
                                        <span class="font-medium">{{ $nutrition->value }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- Langkah Pembuatan (dipersingkat) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900 mb-2">
                            Langkah Pembuatan
                        </h3>
                        @if ($recipe1->steps->isEmpty())
                            <p class="text-xs text-neutral-500">Langkah pembuatan tidak tersedia.</p>
                        @else
                            <ol class="list-decimal list-inside space-y-1 text-sm text-neutral-700">
                                @foreach ($recipe1->steps->take(5) as $step)
                                    <li>{{ $step->instruction }}</li>
                                @endforeach
                            </ol>
                            @if ($recipe1->steps->count() > 5)
                                <p class="mt-1 text-[11px] text-neutral-500">
                                    {{ $recipe1->steps->count() - 5 }} langkah lainnya dapat dilihat di halaman detail
                                    resep.
                                </p>
                            @endif
                        @endif
                    </div>

                    <div>
                        <h3 class="text-xs font-bold tracking-wider uppercase text-neutral-900 mb-2">
                            Langkah Pembuatan
                        </h3>
                        @if ($recipe2->steps->isEmpty())
                            <p class="text-xs text-neutral-500">Langkah pembuatan tidak tersedia.</p>
                        @else
                            <ol class="list-decimal list-inside space-y-1 text-sm text-neutral-700">
                                @foreach ($recipe2->steps->take(5) as $step)
                                    <li>{{ $step->instruction }}</li>
                                @endforeach
                            </ol>
                            @if ($recipe2->steps->count() > 5)
                                <p class="mt-1 text-[11px] text-neutral-500">
                                    {{ $recipe2->steps->count() - 5 }} langkah lainnya dapat dilihat di halaman detail
                                    resep.
                                </p>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- CTA ke detail --}}
                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-3 border-t border-neutral-100">
                    <p class="text-xs sm:text-sm text-neutral-600">
                        Ingin melihat detail penuh salah satu resep? Buka halaman resep untuk rating, komentar, dan
                        informasi lengkapnya.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('customer.recipes.show', $recipe1->id) }}"
                            class="inline-flex items-center rounded-sm bg-neutral-900 px-3 py-1.5 text-[11px] sm:text-xs font-medium text-white hover:bg-neutral-800">
                            Lihat detail {{ \Illuminate\Support\Str::limit($recipe1->name, 24) }}
                        </a>
                        <a href="{{ route('customer.recipes.show', $recipe2->id) }}"
                            class="inline-flex items-center rounded-sm border border-neutral-300 bg-white px-3 py-1.5 text-[11px] sm:text-xs font-medium text-neutral-800 hover:bg-neutral-50">
                            Lihat detail {{ \Illuminate\Support\Str::limit($recipe2->name, 24) }}
                        </a>
                    </div>
                </div>
            </section>
        @endif


    </div>
@endsection
