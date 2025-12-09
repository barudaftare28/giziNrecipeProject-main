{{-- resources/views/customer/recipes/edit.blade.php --}}
@extends('layouts.customer')

@section('title', 'Edit Resep | NutriRecipe')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- Tombol kembali --}}
        <div>
            <a href="{{ route('customer.recipes.show', $recipe->id) }}"
                class="inline-flex items-center text-sm font-medium text-neutral-400 hover:text-neutral-600 gap-2 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke detail resep
            </a>
        </div>

        {{-- Title + Intro --}}
        <div>
            <h1 class="text-2xl sm:text-4xl font-black tracking-widest uppercase text-neutral-900">
                Edit Resep Kamu
            </h1>
            <p class="mt-1 text-sm text-neutral-400">
                Perbarui informasi resep jika ada yang berubah, misalnya komposisi, langkah, atau foto.
            </p>
        </div>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="rounded-sm border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 space-y-1">
                <p class="font-semibold">Ada beberapa hal yang perlu dicek lagi:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <div class="bg-white border border-neutral-100 rounded-sm p-6 md:p-8">
            <form action="{{ route('customer.recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data"
                class="">
                @csrf
                @method('PUT')

                {{-- Informasi Dasar --}}
                <section class="space-y-4">
                    <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                        Informasi Dasar
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-1">
                                Nama Makanan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $recipe->name) }}"
                                class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-1">
                                Durasi Memasak <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="duration" value="{{ old('duration', $recipe->duration) }}"
                                class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-1">
                                Deskripsi Singkat <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="description" rows="3"
                                class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                required>{{ old('description', $recipe->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-1">
                                Foto (ganti jika perlu)
                            </label>
                            @if ($recipe->photo)
                                <img src="{{ $recipe->photo_url }}" alt="{{ $recipe->name }}"
                                    class="w-32 h-32 object-cover rounded-sm mb-2 border border-neutral-200">
                            @endif

                            <input type="file" name="photo"
                                class="w-full text-sm text-neutral-600 file:mr-3 file:rounded-sm file:border-0 file:bg-emerald-50 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-emerald-700 hover:file:bg-emerald-100">
                            <p class="mt-1 text-xs text-neutral-500">
                                Biarkan kosong jika tidak ingin mengganti foto.
                            </p>
                        </div>
                    </div>
                </section>

                <hr class="border-neutral-200 my-12">

                {{-- Bahan & Langkah --}}
                <section class="space-y-4">
                    <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                        Alat, Bahan, dan Langkah
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Bahan --}}
                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-2">
                                Alat & Bahan <span class="text-rose-500">*</span>
                            </label>
                            <div id="ingredients-wrapper" class="space-y-2">
                                @foreach ($recipe->ingredients as $ingredient)
                                    <div class="flex gap-2">
                                        <input type="text" name="ingredients[]" value="{{ $ingredient->item }}"
                                            class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            required>
                                        <button type="button" onclick="removeInput(this)"
                                            class="px-2.5 py-1 rounded-sm bg-rose-50 text-rose-600 text-xs font-medium hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addIngredient()"
                                class="mt-2 inline-flex items-center rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100">
                                + Tambah Bahan
                            </button>
                        </div>

                        {{-- Langkah --}}
                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-2">
                                Langkah Cara Membuat <span class="text-rose-500">*</span>
                            </label>
                            <div id="steps-wrapper" class="space-y-2">
                                @foreach ($recipe->steps as $step)
                                    <div class="flex gap-2">
                                        <input type="text" name="steps[]" value="{{ $step->instruction }}"
                                            class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                            required>
                                        <button type="button" onclick="removeInput(this)"
                                            class="px-2.5 py-1 rounded-sm bg-rose-50 text-rose-600 text-xs font-medium hover:bg-rose-100">
                                            Hapus
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" onclick="addStep()"
                                class="mt-2 inline-flex items-center rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100">
                                + Tambah Langkah
                            </button>
                        </div>
                    </div>
                </section>

                <hr class="border-neutral-200 my-12">

                {{-- Kandungan Gizi --}}
                <section class="space-y-3">
                    <h2 class="text-md font-bold tracking-wider uppercase text-neutral-900">
                        Kandungan Gizi (Opsional)
                    </h2>

                    <div id="nutrition-wrapper" class="space-y-2">
                        @foreach ($recipe->nutritions as $index => $nutrition)
                            <div class="flex gap-2">
                                <input type="text" name="nutritions[{{ $index }}][name]"
                                    value="{{ $nutrition->name }}"
                                    class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    placeholder="Nama gizi (e.g. Kalori)">
                                <input type="text" name="nutritions[{{ $index }}][amount]"
                                    value="{{ $nutrition->value }}"
                                    class="w-40 rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                    placeholder="Contoh: 150 kcal">
                                <button type="button" onclick="removeInput(this)"
                                    class="px-2.5 py-1 rounded-sm bg-rose-50 text-rose-600 text-xs font-medium hover:bg-rose-100">
                                    Hapus
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" onclick="addNutrition()"
                        class="mt-2 inline-flex items-center rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100">
                        + Tambah Informasi Gizi
                    </button>
                </section>

                {{-- Submit --}}
                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center rounded-sm bg-neutral-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-neutral-800">
                        Update Resep
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Dinamis --}}
    <script>
        function removeInput(btn) {
            btn.parentElement.remove();
        }

        function addIngredient() {
            const wrapper = document.getElementById('ingredients-wrapper');
            const div = document.createElement('div');
            div.classList.add('flex', 'gap-2');
            div.innerHTML = `
                <input type="text" name="ingredients[]" class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nama bahan/alat" required>
                <button type="button" onclick="removeInput(this)" class="px-2.5 py-1 rounded-sm bg-rose-50 text-rose-600 text-xs font-medium hover:bg-rose-100">Hapus</button>
            `;
            wrapper.appendChild(div);
        }

        function addStep() {
            const wrapper = document.getElementById('steps-wrapper');
            const div = document.createElement('div');
            div.classList.add('flex', 'gap-2');
            div.innerHTML = `
                <input type="text" name="steps[]" class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Langkah pembuatan" required>
                <button type="button" onclick="removeInput(this)" class="px-2.5 py-1 rounded-sm bg-rose-50 text-rose-600 text-xs font-medium hover:bg-rose-100">Hapus</button>
            `;
            wrapper.appendChild(div);
        }

        let nutritionIndex = {{ $recipe->nutritions->count() }};

        function addNutrition() {
            const wrapper = document.getElementById('nutrition-wrapper');
            const div = document.createElement('div');
            div.classList.add('flex', 'gap-2');
            div.innerHTML = `
                <input type="text" name="nutritions[${nutritionIndex}][name]" class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nama gizi (e.g. Kalori)">
                <input type="text" name="nutritions[${nutritionIndex}][amount]" class="w-40 rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 150 kcal">
                <button type="button" onclick="removeInput(this)" class="px-2.5 py-1 rounded-sm bg-rose-50 text-rose-600 text-xs font-medium hover:bg-rose-100">Hapus</button>
            `;
            wrapper.appendChild(div);
            nutritionIndex++;
        }
    </script>
@endsection
