@extends('layouts.admin')

@section('title', 'Tambah Resep Official | NutriRecipe')
@section('page_title', 'Tambah Resep Official')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Heading --}}
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-neutral-900">
                Tambah Resep Official
            </h1>
            <p class="mt-1 text-sm text-neutral-500">
                Lengkapi informasi resep bergizi dari pakar gizi. Data ini akan tampil sebagai resep official.
            </p>
        </div>

        {{-- Error state --}}
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

        {{-- Form card --}}
        <div class="bg-white border border-neutral-100 rounded-sm p-5 md:p-6">
            <form action="{{ route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Informasi dasar --}}
                <div class="border-b border-neutral-100 pb-4 mb-2">
                    <h2 class="text-sm font-semibold text-neutral-900">Informasi Dasar</h2>
                    <p class="mt-1 text-xs text-neutral-500">
                        Nama makanan, pakar gizi, durasi, dan deskripsi singkat.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nama Makanan --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-neutral-700">
                            Nama Makanan <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Contoh: Salad Buah Yogurt"
                            required
                        >
                    </div>

                    {{-- Pakar Gizi --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-neutral-700">
                            Pakar Gizi <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="nutritionist"
                            value="{{ old('nutritionist') }}"
                            class="w-full rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Nama pakar gizi"
                            required
                        >
                    </div>
                </div>

                {{-- Durasi & Deskripsi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Durasi --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-neutral-700">
                            Durasi <span class="text-rose-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="duration"
                            value="{{ old('duration') }}"
                            class="w-full rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Contoh: 30 menit"
                            required
                        >
                        <p class="text-xs text-neutral-400">Estimasi total waktu dari persiapan hingga siap saji.</p>
                    </div>

                    {{-- Foto --}}
                    <div class="space-y-1.5">
                        <label class="text-sm font-medium text-neutral-700">
                            Foto Resep
                        </label>
                        <input
                            type="file"
                            name="photo"
                            class="block w-full text-sm text-neutral-700 file:mr-3 file:rounded-sm file:border-0 file:bg-emerald-50 file:px-3 file:py-2 file:text-xs file:font-medium file:text-emerald-700 hover:file:bg-emerald-100"
                        >
                        <p class="text-xs text-neutral-400">Format gambar (JPG/PNG), maksimal 2 MB.</p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-neutral-700">
                        Deskripsi Singkat <span class="text-rose-500">*</span>
                    </label>
                    <textarea
                        name="description"
                        rows="3"
                        class="w-full rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        placeholder="Jelaskan secara singkat karakter dan manfaat resep ini."
                        required
                    >{{ old('description') }}</textarea>
                </div>

                {{-- Alat & Bahan --}}
                <div class="border-t border-neutral-100 pt-4 mt-2">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h2 class="text-sm font-semibold text-neutral-900">Alat & Bahan</h2>
                            <p class="mt-1 text-xs text-neutral-500">
                                Tambahkan semua alat dan bahan yang dibutuhkan dalam resep ini.
                            </p>
                        </div>
                        <button
                            type="button"
                            onclick="addIngredient()"
                            class="inline-flex items-center gap-1.5 rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100"
                        >
                            <span class="material-symbols-outlined text-xs">Tambah Baris</span>
                            
                        </button>
                    </div>

                    <div id="ingredients-wrapper" class="space-y-2">
                        <div class="flex gap-2">
                            <input
                                type="text"
                                name="ingredients[]"
                                class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Contoh: 100g dada ayam tanpa kulit"
                                required
                            >
                            <button
                                type="button"
                                onclick="removeInput(this)"
                                class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Langkah --}}
                <div class="border-t border-neutral-100 pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h2 class="text-sm font-semibold text-neutral-900">Langkah Cara Membuat</h2>
                            <p class="mt-1 text-xs text-neutral-500">
                                Jelaskan langkah-langkah secara urut agar mudah diikuti.
                            </p>
                        </div>
                        <button
                            type="button"
                            onclick="addStep()"
                            class="inline-flex items-center gap-1.5 rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100"
                        >
                            <span class="material-symbols-outlined text-xs">Tambah Langkah</span>
                            
                        </button>
                    </div>

                    <div id="steps-wrapper" class="space-y-2">
                        <div class="flex gap-2">
                            <input
                                type="text"
                                name="steps[]"
                                class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Contoh: Tumis bawang putih hingga harum..."
                                required
                            >
                            <button
                                type="button"
                                onclick="removeInput(this)"
                                class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Kandungan Gizi --}}
                <div class="border-t border-neutral-100 pt-4">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h2 class="text-sm font-semibold text-neutral-900">Kandungan Gizi</h2>
                            <p class="mt-1 text-xs text-neutral-500">
                                Isikan komposisi gizi utama per 1 porsi (kalori, protein, karbohidrat, dll).
                            </p>
                        </div>
                        <button
                            type="button"
                            onclick="addNutrition()"
                            class="inline-flex items-center gap-1.5 rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100"
                        >
                            <span class="material-symbols-outlined text-xs">Tambah Gizi</span>
                        </button>
                    </div>

                    <div id="nutrition-wrapper" class="space-y-2">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <input
                                type="text"
                                name="nutritions[0][name]"
                                class="sm:w-1/3 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Contoh: Kalori"
                                required
                            >
                            <input
                                type="text"
                                name="nutritions[0][amount]"
                                class="sm:flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Contoh: 250 kkal"
                                required
                            >
                            <button
                                type="button"
                                onclick="removeInput(this)"
                                class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600"
                            >
                                Hapus
                            </button>
                        </div>
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
                        Simpan Resep
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function removeInput(btn) {
            const parent = btn.parentElement;
            // kalau hanya 1 baris, jangan dihapus semua supaya form tidak kosong total
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
                <input type="text" name="ingredients[]" class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nama bahan/alat" required>
                <button type="button" onclick="removeInput(this)" class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">Hapus</button>
            `;
            wrapper.appendChild(div);
        }

        function addStep() {
            const wrapper = document.getElementById('steps-wrapper');
            const div = document.createElement('div');
            div.className = 'flex gap-2';
            div.innerHTML = `
                <input type="text" name="steps[]" class="flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Langkah pembuatan" required>
                <button type="button" onclick="removeInput(this)" class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">Hapus</button>
            `;
            wrapper.appendChild(div);
        }

        let nutritionIndex = 1;
        function addNutrition() {
            const wrapper = document.getElementById('nutrition-wrapper');
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2';
            div.innerHTML = `
                <input type="text" name="nutritions[${nutritionIndex}][name]" class="sm:w-1/3 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nama gizi" required>
                <input type="text" name="nutritions[${nutritionIndex}][amount]" class="sm:flex-1 rounded-sm border border-neutral-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Jumlah, contoh: 10g" required>
                <button type="button" onclick="removeInput(this)" class="inline-flex items-center justify-center rounded-sm border border-neutral-200 px-2 text-xs text-neutral-500 hover:border-rose-300 hover:text-rose-600">Hapus</button>
            `;
            wrapper.appendChild(div);
            nutritionIndex++;
        }
    </script>
@endsection
