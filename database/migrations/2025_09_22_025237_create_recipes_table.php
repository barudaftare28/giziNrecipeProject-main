<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            
            // TAMBAHAN 1: Mencatat siapa yang posting (Admin atau User?)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('name');
            
            // MODIFIKASI: Boleh kosong (nullable), karena kalau User yang posting,
            // tidak ada nama "Pakar Gizi"-nya.
            $table->string('nutritionist')->nullable(); 

            // TAMBAHAN 2: Penanda apakah ini Resep Official (Admin) atau bukan
            // Default false (berarti resep user), kalau Admin posting set jadi true.
            $table->boolean('is_official')->default(false);

            $table->string('duration'); // Contoh: "45 Menit"
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('recipes');
    }
};