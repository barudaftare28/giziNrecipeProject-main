<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Step;
use App\Models\Nutrition;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     */
    public function dashboard()
    {
        try {
            $recipeCount = Recipe::count();
        } catch (\Exception $e) {
            $recipeCount = '-';
        }

        return view('admin.dashboard', compact(
            'recipeCount',
        ));
    }

    /**
     * Tampilkan semua resep.
     */
    public function index()
    {
        $recipes = Recipe::with(['ingredients', 'steps', 'nutritions'])
            ->withAvg('ratings', 'rating')
            ->withCount('comments')
            ->latest()
            ->get();
    
        return view('admin.recipes.index', compact('recipes'));
    }
    

    /**
     * Form tambah resep baru.
     */
    public function create()
    {
        return view('admin.recipes.create');
    }

    /**
     * Simpan resep baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nutritionist' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Set pemilik dan status resmi resep
        $data['user_id'] = Auth::id();
        $data['is_official'] = true;

        // Upload foto jika ada
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('recipes', 'public');
        }

        $recipe = Recipe::create($data);

        // Tambah bahan
        if ($request->ingredients) {
            foreach ($request->ingredients as $ingredient) {
                if (!empty($ingredient)) {
                    Ingredient::create([
                        'recipe_id' => $recipe->id,
                        'item' => $ingredient,
                    ]);
                }
            }
        }

        // Tambah langkah
        if ($request->steps) {
            foreach ($request->steps as $index => $step) {
                if (!empty($step)) {
                    Step::create([
                        'recipe_id' => $recipe->id,
                        'instruction' => $step,
                        'order' => $index + 1,
                    ]);
                }
            }
        }

        // Tambah kandungan gizi
        if ($request->nutritions) {
            foreach ($request->nutritions as $nutrition) {
                if (!empty($nutrition['name']) && !empty($nutrition['amount'])) {
                    Nutrition::create([
                        'recipe_id' => $recipe->id,
                        'name' => $nutrition['name'],
                        'value' => $nutrition['amount'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil ditambahkan!');
    }

    /**
     * Form edit resep.
     */
    public function edit(Recipe $recipe)
    {
        $recipe->load(['ingredients', 'steps', 'nutritions']);
        return view('admin.recipes.edit', compact('recipe'));
    }

    /**
     * Update resep.
     */
    public function update(Request $request, Recipe $recipe)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'nutritionist' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Upload foto baru jika ada
        if ($request->hasFile('photo')) {
            if ($recipe->photo && Storage::disk('public')->exists($recipe->photo)) {
                Storage::disk('public')->delete($recipe->photo);
            }
            $data['photo'] = $request->file('photo')->store('recipes', 'public');
        }

        $recipe->update($data);

        // Reset bahan, langkah, dan nutrisi lama
        $recipe->ingredients()->delete();
        $recipe->steps()->delete();
        $recipe->nutritions()->delete();

        // Tambah bahan baru
        if ($request->ingredients) {
            foreach ($request->ingredients as $ingredient) {
                if (!empty($ingredient)) { // skip kosong
                    Ingredient::create([
                        'recipe_id' => $recipe->id,
                        'item' => $ingredient,
                    ]);
                }
            }
        }

        // Tambah langkah baru
        if ($request->steps) {
            foreach ($request->steps as $index => $step) {
                if (!empty($step)) { // skip kosong
                    Step::create([
                        'recipe_id' => $recipe->id,
                        'instruction' => $step,
                        'order' => $index + 1,
                    ]);
                }
            }
        }

        // Tambah kandungan gizi baru
        if ($request->nutritions) {
            foreach ($request->nutritions as $nutrition) {
                if (!empty($nutrition['name']) && !empty($nutrition['amount'])) { // skip kosong
                    Nutrition::create([
                        'recipe_id' => $recipe->id,
                        'name' => $nutrition['name'],
                        'value' => $nutrition['amount'],
                    ]);
                }
            }
        }

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil diupdate!');
    }

    /**
     * Hapus resep.
     */
    public function destroy(Recipe $recipe)
    {
        // Hapus foto jika ada
        if ($recipe->photo && Storage::disk('public')->exists($recipe->photo)) {
            Storage::disk('public')->delete($recipe->photo);
        }

        $recipe->delete();

        return redirect()->route('admin.recipes.index')->with('success', 'Resep berhasil dihapus!');
    }

    /**
     * Detail resep.
     */
    public function show(Recipe $recipe)
    {
        $recipe->load([
            'ingredients',
            'steps',
            'nutritions',
            'comments.user',
            'ratings',
        ])->loadCount('ratings');
    
        $averageRating = $recipe->averageRating();
        $comments = $recipe->comments()->latest()->get();
    
        return view('admin.recipes.show', compact('recipe', 'averageRating', 'comments'));
    }
    
}
