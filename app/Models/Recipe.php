<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      // 
        'is_official', //
        'name',
        'nutritionist',
        'duration',
        'description',
        'photo',
    ];

    public function getPhotoUrlAttribute(): string
    {
        // jika tidak ada foto sama sekali
        if (!$this->photo) {
            return '';
        }

        // kalau sudah berupa URL penuh
        if (Str::startsWith($this->photo, ['http://', 'https://'])) {
            return $this->photo;
        }

        // foto dari seeder: disimpan di public/img/...
        if (Str::startsWith($this->photo, ['img/', 'images/', 'recipe images/'])) {
            return asset($this->photo);
        }

        // default: foto upload yang disimpan di storage/app/public
        return asset('storage/' . $this->photo);
    }

    // Relasi ke ingredients
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    // Relasi ke steps
    public function steps()
    {
        return $this->hasMany(Step::class)->orderBy('order');
    }

    // Relasi ke nutrisi
    public function nutritions()
    {
        return $this->hasMany(Nutrition::class);
    }

    // **Relasi ke ratings**
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // App\Models\Recipe.php
    public function averageRating(): float
    {
        return (float) ($this->ratings()->avg('rating') ?? 0);
    }

    // Tiap resep dimiliki satu user, relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isBookmarkedBy($user)
    {
        if (!$user) return false;
        return $this->bookmarks->where('user_id', $user->id)->count() > 0;
    }
}
