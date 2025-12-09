<?php
// app/Http/Controllers/BookmarkController.php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // Function untuk Toggle (Simpan/Hapus)
    public function toggle($recipeId)
    {
        $user = Auth::user();
        
        // Cek apakah user sudah bookmark resep ini?
        $bookmark = Bookmark::where('user_id', $user->id)
                            ->where('recipe_id', $recipeId)
                            ->first();

        if ($bookmark) {
            // Jika sudah ada, hapus (Un-bookmark)
            $bookmark->delete();
            return back()->with('success', 'Resep dihapus dari simpanan.');
        } else {
            // Jika belum ada, buat baru (Simpan)
            Bookmark::create([
                'user_id' => $user->id,
                'recipe_id' => $recipeId
            ]);
            return back()->with('success', 'Resep berhasil disimpan!');
        }
    }

    // Daftar resep yang dibookmark user
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Ambil hanya resep yang dibookmark oleh user ini
        $query = Recipe::with('user')
            ->withAvg('ratings', 'rating')
            ->withCount('comments')
            ->whereHas('bookmarks', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest();

        // Pencarian (nama, durasi, deskripsi, nama pembuat)
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('duration', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter berdasarkan jenis resep (komunitas / official)
        if ($request->type === 'komunitas') {
            $query->where('is_official', false);
        }

        if ($request->type === 'official') {
            $query->where('is_official', true);
        }

        // Paginasi
        $recipes = $query->paginate(9)->withQueryString();

        return view('customer.bookmarks.index', compact('recipes'));
    }
}
