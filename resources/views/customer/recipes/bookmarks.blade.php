@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Header & Tombol Kembali --}}
        <div class="mb-6 flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                ❤️ Resep Favorit Saya
            </h2>
            <a href="{{ route('customer.dashboard') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        {{-- Grid Daftar Resep --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            @forelse($bookmarks as $item)
                {{-- Perhatikan: Kita memanggil $item->recipe karena datanya ada di relasi --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow duration-300">
                    
                    {{-- Foto Resep --}}
                    <div class="h-48 w-full bg-gray-200 overflow-hidden">
                        @if($item->recipe->photo)
                            <img src="{{ asset('storage/' . $item->recipe->photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                        @endif
                    </div>

                    <div class="p-6">
                        <h4 class="font-bold text-xl mb-2 truncate">{{ $item->recipe->name }}</h4>
                        
                        <p class="text-sm text-gray-600 mb-4">
                            Oleh: 
                            @if($item->recipe->is_official)
                                <span class="text-blue-600 font-semibold">Official Giziku</span>
                            @else
                                <span class="text-gray-800">{{ $item->recipe->user->name ?? 'User' }}</span>
                            @endif
                        </p>

                        <div class="flex justify-between items-center mt-4">
                            <a href="{{ route('customer.recipes.show', $item->recipe->id) }}" class="text-green-600 hover:text-green-800 font-semibold text-sm">
                                Lihat Detail &rarr;
                            </a>
                            
                            {{-- Tombol Hapus dari Favorit (Shortcut) --}}
                            <form action="{{ route('recipes.bookmark', $item->recipe->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm" onclick="return confirm('Hapus dari favorit?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 bg-white rounded-lg shadow-sm">
                    <p class="text-gray-500 text-lg mb-4">Belum ada resep yang difavoritkan.</p>
                    <a href="{{ route('customer.recipes.index') }}" class="inline-block px-6 py-2 bg-green-600 text-white rounded-full hover:bg-green-700 transition-colors">
                        Cari Resep Dulu Yuk!
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection