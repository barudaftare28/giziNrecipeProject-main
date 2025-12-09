<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/* Homepage */

Route::get('/', [CustomerController::class, 'dashboard'])
    ->name('customer.dashboard');

/* Redirect setelah login (based on role) */
Route::get('/redirect', function () {
    if (! Auth::check()) {
        return redirect('/login');
    }

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'customer') {
        return redirect()->route('customer.dashboard');
    }

    return redirect('/login');
})->name('redirect');

/* Admin Routes */
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('recipes', AdminController::class);

        // Hapus komentar pada resep (admin only)
        Route::delete('/recipes/{recipe}/comments/{comment}', [CommentController::class, 'destroy'])
            ->name('recipes.comments.destroy');
    });

/* Customer Routes */
Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        // HAPUS: Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

        Route::get('/recipes/compare', [CustomerController::class, 'compare'])
            ->name('recipes.compare');

        Route::get('/recipes/create-rules', [CustomerController::class, 'createRules'])
            ->name('recipes.create-rules');

        Route::resource('recipes', CustomerController::class);
    });

/* Authenticated User Routes (Profile, Rating, Bookmark) */
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rating
    Route::post('/recipes/{recipe}/rating', [RatingController::class, 'store'])->name('ratings.store');

    // Bookmark
    Route::post('/recipes/{recipe}/bookmark', [BookmarkController::class, 'toggle'])->name('recipes.bookmark');

    // Bookmark - halaman daftar bookmark
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');

    // Comment
    Route::post('/recipes/{recipe}/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

require __DIR__ . '/auth.php';
