@extends('layouts.admin')

@section('title', 'Edit Resep | NutriRecipe')
@section('page_title', 'Edit Resep Official')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900">
                Edit Resep: {{ $recipe->name }}
            </h1>
            <p class="mt-1 text-sm text-neutral-500">
                Perbarui informasi resep official. Perubahan akan langsung terlihat oleh pengguna.
            </p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-sm p-4 space-y-1">
                <p class="font-semibold">Terjadi kesalahan pada input:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white border border-neutral-100 rounded-sm p-5 md:p-6">
            <form action="{{ route('admin.recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Info dasar --}}
                <div class="border-b border-neutral-100 pb-4 mb-2">
                    <h2 class="text-sm font-semibold text-neutral-900">Informasi Dasar</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nama Resep --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-neutral-700">Nama Resep</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $recipe->name) }}"
                            class="w-full rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >
                    </div>

                    {{-- Pakar Gizi --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-neutral-700">Pakar Gizi</label>
                        <input
                            type="text"
                            name="nutritionist"
                            value="{{ old('nutritionist', $recipe->nutritionist) }}"
                            class="w-full rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Durasi --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-neutral-700">Durasi</label>
                        <input
                            type="text"
                            name="duration"
                            value="{{ old('duration', $recipe->duration) }}"
                            class="w-full rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >
                    </div>

                    {{-- Foto --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-neutral-700">Foto Resep (opsional)</label>
                        @if ($recipe->photo)
                            <div class="mb-2">
                                @php
                                $img = $recipe->photo
                                    ? $recipe->photo_url ?? asset('storage/' . $recipe->photo)
                                    : 'https://placehold.co/800x600/e2e8f0/e2e8f0?text=NutriRecipe';
                            @endphp
                            <img src="{{ $img }}" alt="{{ $recipe->name }}"
                                class="h-full w-full object-cover group-hover:brightness-95 transition">
                            </div>
                        @endif
                        <input
                            type="file"
                            name="photo"
                            class="block w-full text-sm text-neutral-700 file:mr-3 file:rounded-sm file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:text-xs file:font-medium file:text-emerald-700 hover:file:bg-emerald-100"
                        >
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-700">Deskripsi</label>
                    <textarea
                        name="description"
                        rows="3"
                        class="w-full rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >{{ old('description', $recipe->description) }}</textarea>
                </div>

                {{-- Alat & Bahan --}}
                <div class="border-t border-neutral-100 pt-4 mt-2">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-semibold text-neutral-900">Alat & Bahan</h2>
                        <button type="button"
                                onclick="addIngredient()"
                                class="inline-flex items-center gap-1.5 rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100">
                            <span class="material-symbols-outlined text-xs">Tambah Baris</span>
                            
                        </button>
                    </div>

                    <div id="ingredients-wrapper" class="space-y-2">
                        @foreach ($recipe->ingredients as $ingredient)
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    name="ingredients[]"
                                    value="{{ $ingredient->item }}"
                                    class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                >
                                <button type="button"
                                        onclick="removeInput(this)"
                                        class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">
                                    Hapus
                                </button>
                            </div>
                        @endforeach
                        @if ($recipe->ingredients->isEmpty())
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    name="ingredients[]"
                                    class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm"
                                    placeholder="Tambah bahan"
                                >
                                <button type="button"
                                        onclick="removeInput(this)"
                                        class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">
                                    Hapus
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Langkah --}}
                <div class="border-t border-neutral-100 pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-semibold text-neutral-900">Langkah Cara Membuat</h2>
                        <button type="button"
                                onclick="addStep()"
                                class="inline-flex items-center gap-1.5 rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100">
                            <span class="material-symbols-outlined text-xs">Tambah Langkah</span>
                            
                        </button>
                    </div>

                    <div id="steps-wrapper" class="space-y-2">
                        @foreach ($recipe->steps as $step)
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    name="steps[]"
                                    value="{{ $step->instruction }}"
                                    class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                >
                                <button type="button"
                                        onclick="removeInput(this)"
                                        class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">
                                    Hapus
                                </button>
                            </div>
                        @endforeach
                        @if ($recipe->steps->isEmpty())
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    name="steps[]"
                                    class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm"
                                    placeholder="Tambah langkah"
                                >
                                <button type="button"
                                        onclick="removeInput(this)"
                                        class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">
                                    Hapus
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Kandungan Gizi --}}
                <div class="border-t border-neutral-100 pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-sm font-semibold text-neutral-900">Kandungan Gizi</h2>
                        <button type="button"
                                onclick="addNutrition()"
                                class="inline-flex items-center gap-1.5 rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100">
                            <span class="material-symbols-outlined text-xs">Tambah Gizi</span>
                            
                        </button>
                    </div>

                    <div id="nutrition-wrapper" class="space-y-2">
                        @foreach ($recipe->nutritions as $nutrition)
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input
                                    type="text"
                                    name="nutritions[{{ $loop->index }}][name]"
                                    value="{{ $nutrition->name }}"
                                    class="sm:w-1/3 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                >
                                <input
                                    type="text"
                                    name="nutritions[{{ $loop->index }}][amount]"
                                    value="{{ $nutrition->value }}"
                                    class="sm:flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                >
                                <button type="button"
                                        onclick="removeInput(this)"
                                        class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">
                                    Hapus
                                </button>
                            </div>
                        @endforeach

                        @if ($recipe->nutritions->isEmpty())
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input
                                    type="text"
                                    name="nutritions[0][name]"
                                    class="sm:w-1/3 rounded-sm border border-neutral-300 px-3 py-2 text-sm"
                                    placeholder="Nama gizi"
                                >
                                <input
                                    type="text"
                                    name="nutritions[0][amount]"
                                    class="sm:flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm"
                                    placeholder="Nilai gizi"
                                >
                                <button type="button"
                                        onclick="removeInput(this)"
                                        class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">
                                    Hapus
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="pt-2 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.recipes.index') }}"
                       class="inline-flex items-center rounded-sm border border-neutral-300 px-4 py-2 text-sm font-medium text-neutral-700 hover:bg-neutral-50">
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center rounded-sm bg-emerald-600 px-5 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function removeInput(btn) {
            const parent = btn.parentElement;
            const wrapper = parent.parentElement;
            if (wrapper.children.length > 1) {
                parent.remove();
            }
        }

        function addIngredient() {
            const wrapper = document.getElementById('ingredients-wrapper');
            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="text" name="ingredients[]" class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm" placeholder="Nama bahan">
                <button type="button" onclick="removeInput(this)" class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">Hapus</button>
            `;
            wrapper.appendChild(div);
        }

        function addStep() {
            const wrapper = document.getElementById('steps-wrapper');
            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="text" name="steps[]" class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm" placeholder="Langkah pembuatan">
                <button type="button" onclick="removeInput(this)" class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">Hapus</button>
            `;
            wrapper.appendChild(div);
        }

        let nutritionIndex = {{ $recipe->nutritions->count() }};
        function addNutrition() {
            const wrapper = document.getElementById('nutrition-wrapper');
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2';
            div.innerHTML = `
                <input type="text" name="nutritions[${nutritionIndex}][name]" class="sm:w-1/3 rounded-sm border border-neutral-300 px-3 py-2 text-sm" placeholder="Nama gizi">
                <input type="text" name="nutritions[${nutritionIndex}][amount]" class="sm:flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm" placeholder="Nilai gizi">
                <button type="button" onclick="removeInput(this)" class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">Hapus</button>
            `;
            wrapper.appendChild(div);
            nutritionIndex++;
        }
    </script>
@endsection
