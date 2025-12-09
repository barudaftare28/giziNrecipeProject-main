{{-- resources/views/about.blade.php --}}
@extends('layouts.customer')

@section('title', 'Tentang NutriRecipe | NutriRecipe')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Hero --}}
        <section class="space-y-3 mb-12">
            <h1 class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-neutral-900">
                NutriRecipe
            </h1>
            <p class="max-w-2xl text-sm sm:text-base text-neutral-500">
                NutriRecipe hadir untuk membantu kamu merencanakan dan menikmati makanan yang lebih sehat,
                tanpa harus pusing menghitung gizi setiap hari. Kami menggabungkan resep komunitas dan resep
                dari pakar gizi agar kamu bisa memilih menu yang cocok dengan gaya hidupmu.
            </p>
        </section>

        {{-- 3 Kolom: Misi, Cara Kerja, Untuk Siapa --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-2">
            <div class="bg-white border border-neutral-100 rounded-sm p-5 space-y-2">
                <h2 class="text-xs font-bold tracking-wider uppercase text-neutral-900">
                    Misi Kami
                </h2>
                <p class="text-sm text-neutral-600">
                    Membuat pilihan makan sehat terasa sederhana, dekat, dan relevan untuk aktivitas sehari-hari,
                    bukan hanya saat diet atau sakit.
                </p>
            </div>

            <div class="bg-white border border-neutral-100 rounded-sm p-5 space-y-2">
                <h2 class="text-xs font-bold tracking-wider uppercase text-neutral-900">
                    Apa yang Kami Lakukan
                </h2>
                <p class="text-sm text-neutral-600">
                    Mengkurasi resep dari pakar gizi, membuka ruang bagi komunitas untuk berbagi resep, dan
                    menyajikan informasi gizi yang mudah dibaca sehingga kamu tahu apa yang kamu makan.
                </p>
            </div>

            <div class="bg-white border border-neutral-100 rounded-sm p-5 space-y-2">
                <h2 class="text-xs font-bold tracking-wider uppercase text-neutral-900">
                    Untuk Siapa
                </h2>
                <p class="text-sm text-neutral-600">
                    Untuk kamu yang ingin hidup lebih sehat, orang tua yang menyiapkan makanan di rumah,
                    mahasiswa yang ingin makan lebih teratur, hingga siapa pun yang peduli pada asupan hariannya.
                </p>
            </div>
        </section>

        {{-- Section nilai & pengalaman pengguna --}}
        <section class="bg-white border border-neutral-100 rounded-sm p-6 space-y-6 mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-3">
                    <h2 class="text-sm font-bold tracking-wider uppercase text-neutral-900">
                        Nilai yang Kami Pegang
                    </h2>
                    <ul class="space-y-2 text-sm text-neutral-700">
                        <li class="flex gap-2">
                            <span class="mt-[3px] text-xs font-semibold text-neutral-400">01</span>
                            <span><span class="font-semibold">Sehat dulu, enak menyusul.</span> Rasa penting, tapi tubuh
                                kamu lebih penting.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] text-xs font-semibold text-neutral-400">02</span>
                            <span><span class="font-semibold">Tiap orang berbeda.</span> Kebutuhan gizi tiap orang unik,
                                karena itu kami menyediakan variasi resep dengan informasi yang jelas.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] text-xs font-semibold text-neutral-400">03</span>
                            <span><span class="font-semibold">Komunitas itu kuat.</span> Resep terbaik sering datang dari
                                dapur rumah, bukan hanya dari buku resep.</span>
                        </li>
                    </ul>
                </div>

                <div class="space-y-3">
                    <h2 class="text-sm font-bold tracking-wider uppercase text-neutral-900">
                        Pengalaman di NutriRecipe
                    </h2>
                    <ol class="space-y-2 text-sm text-neutral-700">
                        <li class="flex gap-2">
                            <span class="mt-[3px] text-xs font-semibold text-neutral-400">01</span>
                            <span>Jelajahi resep official dan resep komunitas yang sudah dilengkapi deskripsi,
                                durasi, dan informasi gizi.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] text-xs font-semibold text-neutral-400">02</span>
                            <span>Simpan resep favoritmu, beri rating, dan tulis komentar untuk membantu pengguna lain
                                menemukan menu yang cocok.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="mt-[3px] text-xs font-semibold text-neutral-400">03</span>
                            <span>Buat dan bagikan resep versimu sendiri agar ide masakan sehatmu bisa menginspirasi
                                orang lain.</span>
                        </li>
                    </ol>
                </div>
            </div>

            {{-- Highlight kecil --}}
            <div
                class="mt-2 grid grid-cols-1 sm:grid-cols-3 gap-3 text-center text-xs sm:text-sm text-neutral-600 border-t border-neutral-100 pt-4">
                <div class="flex flex-col gap-1">
                    <span class="text-lg font-bold text-neutral-900 tracking-wider">Resep Official</span>
                    <span>Disusun dan dikurasi oleh pakar gizi.</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-lg font-bold text-neutral-900 tracking-wider">Resep Komunitas</span>
                    <span>Dari pengguna untuk pengguna, dengan sentuhan rumah.</span>
                </div>
                <div class="flex flex-col gap-1">
                    <span class="text-lg font-bold text-neutral-900 tracking-wider">Fokus Gizi</span>
                    <span>Bukan hanya “enak”, tapi juga jelas secara nutrisi.</span>
                </div>
            </div>
        </section>

        {{-- CTA ke resep --}}
        <section class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <p class="text-sm font-bold tracking-wider uppercase text-neutral-900">
                    Siap mulai makan lebih sehat?
                </p>
                <p class="text-sm text-neutral-600 mt-1">
                    Jelajahi kumpulan resep NutriRecipe dan temukan menu yang paling cocok untuk aktivitas harianmu.
                </p>
            </div>
            <a href="{{ route('customer.recipes.index') }}"
                class="inline-flex items-center rounded-sm bg-emerald-600 px-4 py-2 text-xs sm:text-sm font-medium text-white hover:bg-emerald-700">
                Lihat Semua Resep
            </a>
        </section>
    </div>
@endsection
