@extends('layouts.admin')

@section('title', $recipe->name . ' | Detail Resep')
@section('page_title', 'Detail Resep')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">

        {{-- Header dengan gambar --}}
        <div class="bg-white border border-neutral-100 rounded-sm  overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-5">
                <div class="md:col-span-2">
                    @if ($recipe->photo)
                        @php
                                $img = $recipe->photo
                                    ? $recipe->photo_url ?? asset('storage/' . $recipe->photo)
                                    : 'https://placehold.co/800x600/e2e8f0/e2e8f0?text=NutriRecipe';
                            @endphp
                            <img src="{{ $img }}" alt="{{ $recipe->name }}"
                                class="h-full w-full object-cover group-hover:brightness-95 transition">
                    @else
                        <div
                            class="h-56 md:h-full w-full flex items-center justify-center bg-neutral-100 text-sm text-neutral-500">
                            Tidak ada foto
                        </div>
                    @endif
                </div>
                <div class="md:col-span-3 p-5 space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h1 class="text-xl font-semibold text-neutral-900">
                                {{ $recipe->name }}
                            </h1>
                            <p class="mt-1 text-xs text-neutral-500">
                                Resep bergizi & sehat untuk pengguna NutriRecipe.
                            </p>
                        </div>
                        @if ($recipe->is_official)
                            <span
                                class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-emerald-700">
                                Official
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm text-neutral-700">
                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-neutral-500">Pakar Gizi</p>
                            <p>{{ $recipe->nutritionist ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-semibold text-neutral-500">Durasi</p>
                            <p>{{ $recipe->duration ?? '-' }}</p>
                        </div>
                        <div class="space-y-1 sm:col-span-2">
                            <p class="text-xs font-semibold text-neutral-500">Deskripsi</p>
                            <p class="text-sm text-neutral-700">
                                {{ $recipe->description ?? '-' }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Bahan & langkah + gizi --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Bahan --}}
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white border border-neutral-100 rounded-sm  p-5">
                    <h2 class="text-sm font-semibold text-neutral-900 mb-3">Bahan</h2>
                    <ul class="list-disc list-inside text-sm text-neutral-700 space-y-1.5">
                        @forelse ($recipe->ingredients as $ingredient)
                            <li>{{ $ingredient->item }}</li>
                        @empty
                            <li class="text-neutral-400 text-sm"><em>Tidak ada data bahan.</em></li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white border border-neutral-100 rounded-sm  p-5">
                    <h2 class="text-sm font-semibold text-neutral-900 mb-3">Langkah</h2>
                    <ol class="list-decimal list-inside text-sm text-neutral-700 space-y-1.5">
                        @forelse ($recipe->steps as $step)
                            <li>{{ $step->instruction }}</li>
                        @empty
                            <li class="text-neutral-400 text-sm"><em>Tidak ada langkah tersedia.</em></li>
                        @endforelse
                    </ol>
                </div>
            </div>

            {{-- Kandungan gizi --}}
            <div class="space-y-5">
                <div class="bg-white border border-neutral-100 rounded-sm  p-5">
                    <h2 class="text-sm font-semibold text-neutral-900 mb-3">Kandungan Gizi per Porsi</h2>
                    <ul class="text-sm text-neutral-700 space-y-1.5">
                        @forelse ($recipe->nutritions as $nutrition)
                            <li class="flex items-center justify-between gap-2">
                                <span>{{ $nutrition->name }}</span>
                                <span class="text-neutral-900 font-medium">{{ $nutrition->value }}</span>
                            </li>
                        @empty
                            <li class="text-neutral-400 text-sm"><em>Tidak ada data kandungan gizi.</em></li>
                        @endforelse
                    </ul>
                </div>

                <div class="bg-white border border-neutral-100 rounded-sm  p-4">
                    <p class="text-xs text-neutral-500">
                        Catatan: Data gizi ini hanya estimasi berdasarkan standar umum bahan makanan.
                        Sesuaikan kembali jika ada kebutuhan diet khusus.
                    </p>
                </div>
            </div>
        </div>

        {{-- Komentar Pengguna --}}
        <div class="bg-white border border-neutral-100 rounded-sm  p-5 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-neutral-900">Komentar Pengguna</h2>
                <span class="text-xs text-neutral-500">
                    {{ $comments->count() }} komentar
                </span>
            </div>

            @if ($comments->isEmpty())
                <p class="text-sm text-neutral-500">
                    Belum ada komentar untuk resep ini.
                </p>
            @else
                <div class="divide-y divide-neutral-100">
                    @foreach ($comments as $comment)
                        <div class="py-3 flex gap-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-8 h-8 rounded-full bg-neutral-200 flex items-center justify-center text-xs font-semibold text-neutral-700">
                                    {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <div>
                                        <p class="text-sm font-semibold text-neutral-800">
                                            {{ $comment->user->name ?? 'User' }}
                                        </p>
                                        <p class="text-[11px] text-neutral-400">
                                            {{ $comment->created_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <form
                                        action="{{ route('admin.recipes.comments.destroy', [$recipe->id, $comment->id]) }}"
                                        method="POST" onsubmit="return confirm('Hapus komentar ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center rounded-sm border border-rose-400 px-2.5 py-1 text-[11px] font-medium text-rose-600 hover:bg-rose-50">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                                <p class="mt-1 text-sm text-neutral-700">
                                    {{ $comment->body }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>


        {{-- Tombol kembali --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.recipes.index') }}"
                class="inline-flex items-center gap-1 text-sm font-medium text-neutral-700 hover:text-neutral-900">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Kembali ke daftar resep
            </a>

            <div class="flex gap-2">
                <a href="{{ route('admin.recipes.edit', $recipe->id) }}"
                    class="inline-flex items-center rounded-sm border border-emerald-500 px-4 py-2 text-xs md:text-sm font-medium text-emerald-700 hover:bg-emerald-50">
                    Edit Resep
                </a>
            </div>
        </div>
    </div>
@endsection
