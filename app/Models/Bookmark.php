<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    // Izinkan kolom ini diisi
    protected $fillable = ['user_id', 'recipe_id'];

    // Relasi: Bookmark milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Bookmark berisi satu Resep
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }
}