@extends('layouts.admin')

@section('title', 'Kelola Resep | NutriRecipe')
@section('page_title', 'Kelola Resep')

@section('content')
    <div class="space-y-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-neutral-900">
                    Daftar Resep
                </h1>
                <p class="mt-1 text-sm text-neutral-500">
                    Lihat, edit, dan kelola semua resep yang tersimpan di sistem.
                </p>
            </div>

            <a href="{{ route('admin.recipes.create') }}"
                class="inline-flex items-center gap-2 rounded-sm bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                <span class="material-symbols-outlined text-base">Tambah Resep Official</span>

            </a>
        </div>

        @if ($recipes->isEmpty())
            <div class="bg-white border border-neutral-100 rounded-sm p-6 text-sm text-neutral-600">
                <p class="font-medium">Belum ada resep.</p>
                <p class="mt-1 text-neutral-500">
                    Mulai tambahkan resep official pertama Anda dengan menekan tombol
                    <span class="font-semibold">"Tambah Resep Official"</span>.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach ($recipes as $recipe)
                    <div class="bg-white border border-neutral-100 rounded-sm overflow-hidden flex flex-col">
                        {{-- Foto --}}
                        @if ($recipe->photo)
                            @php
                                $img = $recipe->photo
                                    ? $recipe->photo_url ?? asset($recipe->photo)
                                    : 'https://placehold.co/800x600/e2e8f0/e2e8f0?text=NutriRecipe';
                            @endphp
                            <img src="{{ $img }}" alt="{{ $recipe->name }}"
                                class="h-full w-full object-cover group-hover:brightness-95 transition">
                        @else
                            <div
                                class="h-40 w-full flex items-center justify-center bg-neutral-100 text-xs text-neutral-500">
                                Tidak ada foto
                            </div>
                        @endif

                        <div class="flex-1 p-4 flex flex-col gap-2">
                            {{-- Judul + badge --}}
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <h3 class="text-sm font-semibold text-neutral-900 line-clamp-2">
                                        {{ $recipe->name }}
                                    </h3>
                                    <p class="mt-0.5 text-xs text-neutral-500">
                                        Pakar gizi: {{ $recipe->nutritionist ?? '-' }}
                                    </p>
                                </div>
                                @if ($recipe->is_official)
                                    <span
                                        class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-emerald-700">
                                        Official
                                    </span>
                                @endif
                            </div>

                            {{-- Deskripsi singkat --}}
                            <p class="text-xs text-neutral-500 line-clamp-3">
                                {{ \Illuminate\Support\Str::limit($recipe->description, 120) }}
                            </p>

                            {{-- Meta --}}
                            <div class="mt-1 text-xs text-neutral-500 flex items-center justify-between">
                                <span class="inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] text-neutral-400">schedule</span>
                                    <span>{{ $recipe->duration ?? '-' }}</span>
                                </span>
                                <span class="text-[11px]">
                                    Dibuat: {{ $recipe->created_at?->format('d M Y') }}
                                </span>
                            </div>
                        </div>

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
                                <span class="material-symbols-outlined text-xs text-neutral-400">chat_bubble</span>
                                <span>{{ $recipe->comments_count ?? 0 }} komentar</span>
                            </div>
                        </div>


                        {{-- Actions --}}
                        <div class="border-t border-neutral-100 px-4 py-3 flex items-center justify-between gap-2">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.recipes.show', $recipe->id) }}"
                                    class="inline-flex items-center rounded-sm border border-neutral-300 px-3 py-1.5 text-xs font-medium text-neutral-700 hover:bg-neutral-50">
                                    Detail
                                </a>
                                <a href="{{ route('admin.recipes.edit', $recipe->id) }}"
                                    class="inline-flex items-center rounded-sm border border-emerald-500 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-50">
                                    Edit
                                </a>
                            </div>
                            <form action="{{ route('admin.recipes.destroy', $recipe->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center rounded-sm border border-rose-500 px-3 py-1.5 text-xs font-medium text-rose-600 hover:bg-rose-50">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
