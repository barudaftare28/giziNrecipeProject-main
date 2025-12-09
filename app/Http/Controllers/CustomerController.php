<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Ingredient;
use App\Models\Nutrition;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Dashboard customer.
     * Menampilkan ringkasan jumlah resep milik user dan jumlah bookmark.
     */
    public function dashboard()
    {
        // Ringkasan global
        if (Auth::check()) {
            $userId = Auth::id();
            $recipeCount    = Recipe::count();                // total semua resep
            $bookmarksCount = Bookmark::where('user_id', $userId)->count();
            $userName       = Auth::user()->name;
        } else {
            $recipeCount    = Recipe::count();
            $bookmarksCount = 0;
            $userName       = null;
        }

        // 1) Hero recipe (paling baru)
        $heroRecipe = Recipe::withAvg('ratings', 'rating')
            ->withCount('comments')
            ->latest()
            ->first();

        // 2) "Jangan Terlewat" – 3 resep terbaru
        $dontMissRecipes = Recipe::withAvg('ratings', 'rating')
            ->withCount('comments')
            ->latest()
            ->take(3)
            ->get();

        // 3) Resep official pakar gizi
        $officialRecipes = Recipe::where('is_official', true)
            ->withAvg('ratings', 'rating')
            ->latest()
            ->take(6)
            ->get();

        // 4) Resep komunitas terbaru
        $communityRecipes = Recipe::where('is_official', false)
            ->withAvg('ratings', 'rating')
            ->latest()
            ->take(6)
            ->get();

        // 5) Resep cepat & praktis (heuristik dari durasi)
        $quickRecipes = Recipe::where('duration', 'like', '%menit%')
            ->orWhere('duration', 'like', '%minute%')
            ->orWhere('duration', 'like', '%quick%')
            ->latest()
            ->take(6)
            ->get();

        // 6) Fan favorites – rating tertinggi
        $fanFavorites = Recipe::withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating')
            ->latest()
            ->take(6)
            ->get();

        return view('customer.dashboard', compact(
            'recipeCount',
            'bookmarksCount',
            'userName',
            'heroRecipe',
            'dontMissRecipes',
            'officialRecipes',
            'communityRecipes',
            'quickRecipes',
            'fanFavorites'
        ));
    }



    /**
     * Menampilkan daftar semua resep (list resep user & admin).
     */
    public function index(Request $request)
    {
        // Query dasar: load relasi user, rata-rata rating, dan jumlah komentar
        $query = Recipe::with('user')
            ->withAvg('ratings', 'rating')
            ->withCount('comments')
            ->latest();

        // Fitur pencarian: nama resep, durasi, deskripsi, dan nama pembuat
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

        $recipes = $query->paginate(10)->withQueryString();

        return view('customer.recipes.index-user', compact('recipes'));
    }

    /**
     * Menampilkan detail satu resep.
     */
    public function show(Recipe $recipe)
    {
        // Load relasi yang dibutuhkan untuk tampilan detail
        $recipe->load([
            'ingredients',
            'steps' => function ($q) {
                $q->orderBy('order');
            },
            'nutritions',
            'user',
            'ratings.user',
            'comments.user',
        ])->loadCount('ratings');

        $averageRating = $recipe->averageRating();

        $userRating = null;
        if (Auth::check()) {
            $userRating = $recipe->ratings->firstWhere('user_id', Auth::id());
        }

        // urutkan komentar terbaru di atas
        $comments = $recipe->comments->sortByDesc('created_at');

        return view('customer.recipes.show-user', compact(
            'recipe',
            'averageRating',
            'userRating',
            'comments'
        ));
    }

    /**
     * Menampilkan form tambah resep.
     */
    public function create()
    {
        return view('customer.recipes.create-user');
    }

    /**
     * Menyimpan resep baru dari user.
     */
    public function store(Request $request)
    {
        // Validasi input utama resep dan relasi
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|string',
            'steps' => 'required|array',
            'steps.*' => 'required|string',
            'nutritions' => 'nullable|array',
            'nutritions.*.name' => 'nullable|string',
            'nutritions.*.amount' => 'nullable|string',
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('recipes', 'public');
        }

        // Set pemilik resep dan tandai sebagai resep user
        $data['user_id'] = Auth::id();
        $data['is_official'] = false;

        // Simpan data resep utama
        $recipe = Recipe::create($data);

        // Simpan ingredients
        if ($request->ingredients) {
            foreach ($request->ingredients as $ingredient) {
                if (! empty($ingredient)) {
                    Ingredient::create([
                        'recipe_id' => $recipe->id,
                        'item' => $ingredient,
                    ]);
                }
            }
        }

        // Simpan steps
        if ($request->steps) {
            foreach ($request->steps as $index => $step) {
                if (! empty($step)) {
                    Step::create([
                        'recipe_id' => $recipe->id,
                        'instruction' => $step,
                        'order' => $index + 1,
                    ]);
                }
            }
        }

        // Simpan nutritions
        if ($request->nutritions) {
            foreach ($request->nutritions as $nutrition) {
                if (! empty($nutrition['name']) && ! empty($nutrition['amount'])) {
                    Nutrition::create([
                        'recipe_id' => $recipe->id,
                        'name' => $nutrition['name'],
                        'value' => $nutrition['amount'],
                    ]);
                }
            }
        }

        return redirect()->route('customer.dashboard')->with('success', 'Resep kamu berhasil diposting!');
    }

    /**
     * Menampilkan form edit resep milik user.
     */
    public function edit(Recipe $recipe)
    {
        // Otorisasi: hanya pemilik resep yang boleh mengedit
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK BERHAK MENGEDIT RESEP INI');
        }

        $recipe->load(['ingredients', 'steps', 'nutritions']);

        return view('customer.recipes.edit-user', compact('recipe'));
    }

    /**
     * Menyimpan perubahan (update) resep milik user.
     */
    public function update(Request $request, Recipe $recipe)
    {
        // Otorisasi: hanya pemilik resep yang boleh mengupdate
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK BERHAK MENGUPDATE RESEP INI');
        }

        // Validasi input utama resep dan relasi
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'ingredients' => 'required|array',
            'ingredients.*' => 'required|string',
            'steps' => 'required|array',
            'steps.*' => 'required|string',
            'nutritions' => 'nullable|array',
            'nutritions.*.name' => 'nullable|string',
            'nutritions.*.amount' => 'nullable|string',
        ]);

        // Update foto jika diganti
        if ($request->hasFile('photo')) {
            if ($recipe->photo && Storage::disk('public')->exists($recipe->photo)) {
                Storage::disk('public')->delete($recipe->photo);
            }
            $data['photo'] = $request->file('photo')->store('recipes', 'public');
        }

        // Update data resep utama
        $recipe->update($data);

        // Hapus relasi lama sebelum menambahkan yang baru
        $recipe->ingredients()->delete();
        $recipe->steps()->delete();
        $recipe->nutritions()->delete();

        // Simpan ulang ingredients
        if ($request->ingredients) {
            foreach ($request->ingredients as $ingredient) {
                if (! empty($ingredient)) {
                    Ingredient::create([
                        'recipe_id' => $recipe->id,
                        'item' => $ingredient,
                    ]);
                }
            }
        }

        // Simpan ulang steps
        if ($request->steps) {
            foreach ($request->steps as $index => $step) {
                if (! empty($step)) {
                    Step::create([
                        'recipe_id' => $recipe->id,
                        'instruction' => $step,
                        'order' => $index + 1,
                    ]);
                }
            }
        }

        // Simpan ulang nutritions
        if ($request->nutritions) {
            foreach ($request->nutritions as $nutrition) {
                if (! empty($nutrition['name']) && ! empty($nutrition['amount'])) {
                    Nutrition::create([
                        'recipe_id' => $recipe->id,
                        'name' => $nutrition['name'],
                        'value' => $nutrition['amount'],
                    ]);
                }
            }
        }

        return redirect()->route('customer.recipes.show', $recipe->id)->with('success', 'Resep berhasil diupdate!');
    }

    /**
     * Menghapus resep milik user.
     */
    public function destroy(Recipe $recipe)
    {
        // Otorisasi: hanya pemilik resep yang boleh menghapus
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK BERHAK MENGHAPUS RESEP INI');
        }

        // Hapus foto jika masih ada di storage
        if ($recipe->photo && Storage::disk('public')->exists($recipe->photo)) {
            Storage::disk('public')->delete($recipe->photo);
        }

        $recipe->delete();

        return redirect()->route('customer.dashboard')->with('success', 'Resep berhasil dihapus!');
    }

    public function compare(Request $request)
    {
        $recipe1Id = $request->query('recipe1');
        $recipe2Id = $request->query('recipe2');

        if (! $recipe1Id) {
            $recipes = Recipe::orderBy('name')
                ->get(['id', 'name', 'is_official']);

            return view('customer.recipes.compare-user', [
                'recipe1' => null,
                'recipe2' => null,
                'otherRecipes' => $recipes, // dipakai sebagai list pilihan resep pertama
            ]);
        }

        $recipe1 = Recipe::with(['user', 'ingredients', 'nutritions', 'steps'])
            ->withAvg('ratings', 'rating')
            ->withCount(['ratings', 'comments'])
            ->findOrFail($recipe1Id);

        // Resep kedua (jika sudah dipilih)
        $recipe2 = null;
        if ($recipe2Id) {
            $recipe2 = Recipe::with(['user', 'ingredients', 'nutritions', 'steps'])
                ->withAvg('ratings', 'rating')
                ->withCount(['ratings', 'comments'])
                ->findOrFail($recipe2Id);
        }

        // Daftar resep lain untuk pilihan resep pembanding (kecuali resep pertama)
        $otherRecipes = Recipe::where('id', '!=', $recipe1->id)
            ->orderBy('name')
            ->get(['id', 'name', 'is_official']);

        return view('customer.recipes.compare-user', [
            'recipe1' => $recipe1,
            'recipe2' => $recipe2,
            'otherRecipes' => $otherRecipes,
        ]);
    }

    public function createRules()
    {
        return view('customer.recipes.create-rules');
    }
}
