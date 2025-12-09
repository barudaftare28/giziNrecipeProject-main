{{-- resources/views/customer/recipes/create-rules.blade.php --}}
@extends('layouts.customer')

@section('title', 'Panduan Membuat Resep | NutriRecipe')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        {{-- Header --}}
        <section class="space-y-2">
            <h1 class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-neutral-900">
                Panduan Membuat Resep
            </h1>
            <p class="max-w-2xl text-sm text-neutral-500">
                Untuk menjaga kualitas komunitas dan keamanan pengguna, mohon baca dan pahami terlebih dahulu beberapa
                aturan berikut sebelum membagikan resep kamu.
            </p>
        </section>

        {{-- Card aturan --}}
        <section class="bg-white border border-neutral-100 rounded-sm p-6 space-y-4">
            <h2 class="text-sm font-bold tracking-wider uppercase text-neutral-900">
                Aturan & Etika Membagikan Resep
            </h2>

            <ul class="space-y-2 text-sm text-neutral-700 list-disc list-inside">
                <li>
                    Tulis bahan dan langkah dengan jelas, lengkap, dan mudah diikuti. Gunakan satuan yang konsisten
                    (gram, ml, sdm, sdt, dll).
                </li>
                <li>
                    Cantumkan takaran gizi hanya jika kamu yakin dengan datanya. Hindari klaim kesehatan yang berlebihan
                    atau belum terbukti.
                </li>
                <li>
                    Dilarang menyertakan konten yang mengandung SARA, ujaran kebencian, pornografi, atau hal yang tidak
                    pantas.
                </li>
                <li>
                    Jika resep terinspirasi dari sumber lain, cantumkan kredit seperlunya (misalnya nama buku, kanal,
                    atau kreator).
                </li>
                <li>
                    Foto yang diunggah harus relevan dengan resep dan bukan mengandung watermark promosi berlebihan.
                </li>
                <li>
                    Tim NutriRecipe berhak menyembunyikan atau menghapus resep yang melanggar aturan di atas.
                </li>
            </ul>

            {{-- Agreement --}}
            <form action="{{ route('customer.recipes.create') }}" method="GET" class="space-y-4">
                <label class="flex items-start gap-2 text-sm text-neutral-700 cursor-pointer">
                    <input type="checkbox" id="agree_rules"
                        class="mt-1 h-4 w-4 rounded border-neutral-300 text-emerald-600 focus:ring-emerald-500">
                    <span>
                        Saya sudah membaca dan memahami aturan di atas, serta bersedia mematuhi pedoman komunitas
                        NutriRecipe saat membagikan resep.
                    </span>
                </label>

                <button type="submit" id="continue_btn"
                    class="inline-flex items-center rounded-sm bg-neutral-300 px-5 py-2 text-sm font-medium text-white cursor-not-allowed transition-colors">
                    Lanjut buat resep
                </button>
            </form>
        </section>
    </div>

    {{-- Script kecil untuk mengaktifkan tombol setelah checkbox dicentang --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('agree_rules');
            const button = document.getElementById('continue_btn');

            if (!checkbox || !button) return;

            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    button.classList.remove('bg-neutral-300', 'cursor-not-allowed');
                    button.classList.add('bg-emerald-600', 'hover:bg-emerald-700');
                    button.disabled = false;
                } else {
                    button.classList.add('bg-neutral-300', 'cursor-not-allowed');
                    button.classList.remove('bg-emerald-600', 'hover:bg-emerald-700');
                    button.disabled = true;
                }
            });

            // default: tombol nonaktif
            button.disabled = true;
        });
    </script>
@endsection
