{{-- resources/views/customer/recipes/create.blade.php --}}
@extends('layouts.customer')

@section('title', 'Buat Resep Baru | NutriRecipe')

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

        {{-- Title + Intro --}}
        <div>
            <h1 class="text-2xl sm:text-4xl font-black tracking-widest uppercase text-neutral-900">
                Buat Resep Baru Kamu
            </h1>
            <p class="mt-1 text-sm text-neutral-400">
                Isi informasi dasar, bahan, langkah, lalu tambahkan kandungan gizi jika kamu mengetahuinya.
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
            <form action="{{ route('customer.recipes.store') }}" method="POST" enctype="multipart/form-data"
                class="">
                @csrf

                {{-- Informasi Dasar --}}
                <section class="space-y-4">
                    <h2 class="text-md font-bold tracking-wider mb-6 uppercase text-neutral-900">
                        Informasi Dasar
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-1">
                                Nama Makanan <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Contoh: Nasi ayam panggang rendah lemak" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-1">
                                Durasi Memasak <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="duration" value="{{ old('duration') }}"
                                class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Contoh: 30 menit" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-1">
                                Deskripsi Singkat <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="description" rows="3"
                                class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="Contoh: Makan siang simpel dengan protein tinggi dan lemak rendah." required>{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-800 mb-1">
                                Foto (opsional)
                            </label>
                            <input type="file" name="photo"
                                class="w-full text-sm text-neutral-600 file:mr-3 file:rounded-sm file:border-0 file:bg-emerald-50 file:px-3 file:py-1.5 file:text-xs file:font-medium file:text-emerald-700 hover:file:bg-emerald-100">
                            <p class="mt-1 text-xs text-neutral-500">
                                Disarankan rasio mendekati 4:3 atau 16:9 agar tampilan lebih rapi.
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
                                <div class="flex gap-2">
                                    <input type="text" name="ingredients[]"
                                        class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Contoh: 1 siung bawang putih" required>
                                    <button type="button" onclick="removeInput(this)"
                                        class="px-2.5 py-1 rounded-sm bg-rose-50 text-rose-600 text-xs font-medium hover:bg-rose-100">
                                        Hapus
                                    </button>
                                </div>
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
                                <div class="flex gap-2">
                                    <input type="text" name="steps[]"
                                        class="w-full rounded-sm border border-neutral-200 px-3 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        placeholder="Contoh: Tumis bumbu hingga harum" required>
                                    <button type="button" onclick="removeInput(this)"
                                        class="px-2.5 py-1 rounded-sm bg-rose-50 text-rose-600 text-xs font-medium hover:bg-rose-100">
                                        Hapus
                                    </button>
                                </div>
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
                    <p class="text-xs text-neutral-500">
                        Isi jika kamu tahu takaran gizinya. Misalnya: Kalori 250 kcal, Protein 15 g, Lemak 5 g.
                    </p>

                    <div id="nutrition-wrapper" class="space-y-2">
                        {{-- default kosong, user bisa tambah sendiri --}}
                    </div>
                    <button type="button" onclick="addNutrition()"
                        class="inline-flex items-center rounded-sm bg-emerald-50 px-3 py-1.5 text-xs font-medium text-emerald-700 hover:bg-emerald-100">
                        + Tambah Informasi Gizi
                    </button>
                </section>

                {{-- Submit --}}
                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center rounded-sm bg-neutral-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-neutral-800">
                        Posting Resep
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

        let nutritionIndex = 0;

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
