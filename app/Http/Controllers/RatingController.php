<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * Simpan rating user untuk resep
     */
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $userId = Auth::id();
        // Larang pemilik resep memberi rating untuk resepnya sendiri
        if ($recipe->user_id === $userId) {
            return redirect()->back()->with('error', 'Kamu tidak bisa memberi rating pada resep milikmu sendiri.');
        }


        // Cek apakah user sudah memberi rating
        $existing = Rating::where('recipe_id', $recipe->id)
                          ->where('user_id', $userId)
                          ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah memberi rating pada resep ini.');
        }

        // Simpan rating baru
        Rating::create([
            'recipe_id' => $recipe->id,
            'user_id' => $userId,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Rating berhasil diberikan!');
    }
}
